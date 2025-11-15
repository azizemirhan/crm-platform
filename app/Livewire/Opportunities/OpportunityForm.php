<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use App\Models\Contact;
use Livewire\Component;

class OpportunityForm extends Component
{
    public $contactId;
    public $name;
    public $description;
    public $amount;
    public $stage = 'qualification';
    public $probability = 50;
    public $expected_close_date;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'amount' => 'required|numeric|min:0',
        'stage' => 'required|in:qualification,proposal,negotiation,closed_won,closed_lost',
        'probability' => 'required|integer|min:0|max:100',
        'expected_close_date' => 'required|date',
    ];

    public function mount($contactId)
    {
        $this->contactId = $contactId;
        $contact = Contact::findOrFail($contactId);
        $this->name = "Fırsat - " . $contact->full_name;
    }

    public function save()
    {
        $this->validate();

        Opportunity::create([
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'stage' => $this->stage,
            'probability' => $this->probability,
            'expected_close_date' => $this->expected_close_date,
            'contact_id' => $this->contactId,
            'owner_id' => auth()->id(),
        ]);

        session()->flash('success', 'Fırsat oluşturuldu.');
        return $this->redirect(route('contacts.show', $this->contactId));
    }

    public function render()
    {
        return view('livewire.opportunities.opportunity-form');
    }
}
