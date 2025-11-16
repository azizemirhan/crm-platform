<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use App\Models\User;
use Livewire\Component;

class AccountForm extends Component
{
    public ?Account $account = null;
    public bool $editMode = false;

    // Form fields
    public $name = '';
    public $legal_name = '';
    public $tax_number = '';
    public $tax_office = '';
    public $website = '';
    public $email = '';
    public $phone = '';
    public $fax = '';
    public $industry = '';
    public $type = '';
    public $size = '';
    public $employee_count = '';
    public $annual_revenue = '';
    public $currency = 'TRY';
    public $description = '';
    public $owner_id = '';

    // Address fields
    public $billing_address_line1 = '';
    public $billing_address_line2 = '';
    public $billing_city = '';
    public $billing_state = '';
    public $billing_postal_code = '';
    public $billing_country = 'Türkiye';

    public $shipping_address_line1 = '';
    public $shipping_address_line2 = '';
    public $shipping_city = '';
    public $shipping_state = '';
    public $shipping_postal_code = '';
    public $shipping_country = 'Türkiye';

    // Social media
    public $linkedin_url = '';
    public $twitter_handle = '';
    public $facebook_url = '';

    public function mount(?Account $account = null)
    {
        if ($account && $account->exists) {
            $this->account = $account;
            $this->editMode = true;
            $this->fill($account->toArray());
        } else {
            $this->owner_id = auth()->id();
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'tax_office' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'type' => 'nullable|in:customer,prospect,partner,vendor,other',
            'size' => 'nullable|in:small,medium,large,enterprise',
            'employee_count' => 'nullable|integer|min:0',
            'annual_revenue' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',
            'shipping_address_line1' => 'nullable|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_handle' => 'nullable|string|max:100',
            'facebook_url' => 'nullable|url|max:255',
        ]);

        $validated['team_id'] = auth()->user()->team_id ?? 1;

        if ($this->editMode) {
            $this->account->update($validated);
            session()->flash('success', 'Şirket başarıyla güncellendi.');
            return redirect()->route('accounts.show', $this->account);
        } else {
            $account = Account::create($validated);
            session()->flash('success', 'Şirket başarıyla oluşturuldu.');
            return redirect()->route('accounts.show', $account);
        }
    }

    public function copyBillingToShipping()
    {
        $this->shipping_address_line1 = $this->billing_address_line1;
        $this->shipping_address_line2 = $this->billing_address_line2;
        $this->shipping_city = $this->billing_city;
        $this->shipping_state = $this->billing_state;
        $this->shipping_postal_code = $this->billing_postal_code;
        $this->shipping_country = $this->billing_country;
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.accounts.account-form', [
            'users' => $users,
        ]);
    }
}
