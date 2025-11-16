<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Livewire\Component;

class OpportunityForm extends Component
{
    public ?Opportunity $opportunity = null;
    public bool $editMode = false;

    public $name = '';
    public $account_id = '';
    public $contact_id = '';
    public $owner_id = '';
    public $amount = '';
    public $currency = 'TRY';
    public $stage = 'qualification';
    public $probability = 25;
    public $expected_close_date = '';
    public $lead_source = '';
    public $description = '';
    public $next_steps = '';

    public function mount(?Opportunity $opportunity = null)
    {
        if ($opportunity && $opportunity->exists) {
            $this->opportunity = $opportunity;
            $this->editMode = true;
            $this->fill($opportunity->toArray());
            if ($opportunity->expected_close_date) {
                $this->expected_close_date = $opportunity->expected_close_date->format('Y-m-d');
            }
        } else {
            $this->owner_id = auth()->id();
            $this->expected_close_date = now()->addDays(30)->format('Y-m-d');
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'owner_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'stage' => 'required|in:' . implode(',', array_keys(Opportunity::$stages)),
            'probability' => 'required|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'lead_source' => 'nullable|in:' . implode(',', array_keys(Opportunity::$sources)),
            'description' => 'nullable|string',
            'next_steps' => 'nullable|string',
        ]);

        $validated['team_id'] = auth()->user()->team_id ?? 1;
        $validated['weighted_amount'] = ($validated['amount'] * $validated['probability']) / 100;

        if ($this->editMode) {
            $this->opportunity->update($validated);
            session()->flash('success', 'Fırsat güncellendi.');
            return redirect()->route('opportunities.show', $this->opportunity);
        } else {
            $opportunity = Opportunity::create($validated);
            session()->flash('success', 'Fırsat oluşturuldu.');
            return redirect()->route('opportunities.show', $opportunity);
        }
    }

    public function render()
    {
        return view('livewire.opportunities.opportunity-form', [
            'users' => User::orderBy('name')->get(),
            'accounts' => Account::orderBy('name')->get(),
            'contacts' => Contact::orderBy('first_name')->get(),
        ]);
    }
}
