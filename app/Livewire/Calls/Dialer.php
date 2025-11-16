<?php

namespace App\Livewire\Calls;

use App\Models\Call;
use App\Models\Contact;
use App\Models\Lead;
use Livewire\Component;
use Twilio\Rest\Client;

class Dialer extends Component
{
    public $phoneNumber = '';
    public $relatedToType = '';
    public $relatedToId = '';
    public $calling = false;
    public $currentCall = null;

    // Search for contacts/leads
    public $searchTerm = '';
    public $searchResults = [];

    protected $rules = [
        'phoneNumber' => 'required|string',
    ];

    /**
     * Search for contacts/leads
     */
    public function updatedSearchTerm()
    {
        if (strlen($this->searchTerm) < 2) {
            $this->searchResults = [];
            return;
        }

        $contacts = Contact::where('team_id', auth()->user()->team_id)
            ->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('email', 'like', "%{$this->searchTerm}%")
                    ->orWhere('phone', 'like', "%{$this->searchTerm}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($contact) {
                return [
                    'type' => 'contact',
                    'id' => $contact->id,
                    'name' => $contact->full_name,
                    'phone' => $contact->phone,
                    'email' => $contact->email,
                ];
            });

        $leads = Lead::where('team_id', auth()->user()->team_id)
            ->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('email', 'like', "%{$this->searchTerm}%")
                    ->orWhere('phone', 'like', "%{$this->searchTerm}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($lead) {
                return [
                    'type' => 'lead',
                    'id' => $lead->id,
                    'name' => $lead->full_name,
                    'phone' => $lead->phone,
                    'email' => $lead->email,
                ];
            });

        $this->searchResults = $contacts->merge($leads)->toArray();
    }

    /**
     * Select contact/lead from search
     */
    public function selectResult($type, $id, $phone)
    {
        $this->phoneNumber = $phone;
        $this->relatedToType = $type === 'contact' ? 'App\\Models\\Contact' : 'App\\Models\\Lead';
        $this->relatedToId = $id;
        $this->searchResults = [];
        $this->searchTerm = '';
    }

    /**
     * Add digit to phone number
     */
    public function addDigit($digit)
    {
        $this->phoneNumber .= $digit;
    }

    /**
     * Clear phone number
     */
    public function clearNumber()
    {
        $this->phoneNumber = '';
        $this->relatedToType = '';
        $this->relatedToId = '';
    }

    /**
     * Backspace one digit
     */
    public function backspace()
    {
        $this->phoneNumber = substr($this->phoneNumber, 0, -1);
    }

    /**
     * Initiate call
     */
    public function call()
    {
        $this->validate();

        // Get Twilio integration
        $twilioIntegration = \App\Models\Integration::getConfig('twilio', auth()->user()->team_id);

        if (!$twilioIntegration) {
            session()->flash('error', 'Twilio integration not configured. Please configure it in Settings > Integrations.');
            return;
        }

        try {
            $call = Call::create([
                'team_id' => auth()->user()->team_id,
                'user_id' => auth()->id(),
                'direction' => 'outbound',
                'from_number' => $twilioIntegration->getCredential('phone_number'),
                'to_number' => $this->phoneNumber,
                'related_to_type' => $this->relatedToType ?: null,
                'related_to_id' => $this->relatedToId ?: null,
                'status' => 'queued',
            ]);

            // Initiate Twilio call
            $twilio = new Client(
                $twilioIntegration->getCredential('sid'),
                $twilioIntegration->getCredential('token')
            );

            $twilioCall = $twilio->calls->create(
                $this->phoneNumber,
                $twilioIntegration->getCredential('phone_number'),
                [
                    'record' => true,
                    'statusCallback' => route('calls.webhook.status', $call),
                    'statusCallbackEvent' => ['initiated', 'ringing', 'answered', 'completed']
                ]
            );

            $call->update([
                'call_sid' => $twilioCall->sid,
                'status' => $twilioCall->status,
            ]);

            $twilioIntegration->incrementUsage();

            $this->currentCall = $call;
            $this->calling = true;

            session()->flash('success', 'Call initiated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to initiate call: ' . $e->getMessage());
        }
    }

    /**
     * End call
     */
    public function endCall()
    {
        $this->calling = false;
        $this->currentCall = null;
        $this->clearNumber();
    }

    public function render()
    {
        return view('livewire.calls.dialer');
    }
}
