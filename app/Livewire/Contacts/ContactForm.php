<?php

namespace App\Livewire\Contacts;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Livewire\Component;

class ContactForm extends Component
{
    public ?Contact $contact = null;
    public bool $isEditMode = false;

    // Form fields
    public ?int $account_id = null;
    public ?int $owner_id = null;
    public ?string $salutation = null;
    public string $first_name = '';
    public string $last_name = '';
    public ?string $middle_name = null;
    public string $email = '';
    public ?string $secondary_email = null;
    public ?string $phone = null;
    public ?string $mobile = null;
    public ?string $whatsapp = null;
    public ?string $title = null;
    public ?string $department = null;
    public ?string $birthdate = null;
    public ?string $linkedin_url = null;
    
    // Address
    public ?string $mailing_street = null;
    public ?string $mailing_city = null;
    public ?string $mailing_state = null;
    public ?string $mailing_postal_code = null;
    public string $mailing_country = 'TR';
    
    // Other
    public ?string $lead_source = null;
    public string $status = 'active';
    public ?string $description = null;
    
    // UI state
    public bool $showAdvanced = false;

    protected function rules(): array
    {
        $emailRule = $this->isEditMode 
            ? 'required|email|unique:contacts,email,' . $this->contact->id
            : 'required|email|unique:contacts,email';

        return [
            'account_id' => 'nullable|exists:accounts,id',
            'owner_id' => 'nullable|exists:users,id',
            'salutation' => 'nullable|in:Mr,Mrs,Ms,Dr,Prof',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => $emailRule,
            'secondary_email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'linkedin_url' => 'nullable|url',
            'mailing_street' => 'nullable|string',
            'mailing_city' => 'nullable|string|max:100',
            'mailing_state' => 'nullable|string|max:100',
            'mailing_postal_code' => 'nullable|string|max:20',
            'mailing_country' => 'nullable|string|max:2',
            'lead_source' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,disqualified',
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'first_name.required' => 'İsim alanı zorunludur.',
        'last_name.required' => 'Soyisim alanı zorunludur.',
        'email.required' => 'E-posta adresi zorunludur.',
        'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
    ];

    public function mount(?int $contactId = null): void
    {
        if ($contactId) {
            $this->contact = Contact::findOrFail($contactId);
            $this->isEditMode = true;
            $this->fillForm();
        } else {
            $this->owner_id = auth()->id();
        }
    }

    private function fillForm(): void
    {
        $this->account_id = $this->contact->account_id;
        $this->owner_id = $this->contact->owner_id;
        $this->salutation = $this->contact->salutation;
        $this->first_name = $this->contact->first_name;
        $this->last_name = $this->contact->last_name;
        $this->middle_name = $this->contact->middle_name;
        $this->email = $this->contact->email;
        $this->secondary_email = $this->contact->secondary_email;
        $this->phone = $this->contact->phone;
        $this->mobile = $this->contact->mobile;
        $this->whatsapp = $this->contact->whatsapp;
        $this->title = $this->contact->title;
        $this->department = $this->contact->department;
        $this->birthdate = $this->contact->birthdate?->format('Y-m-d');
        $this->linkedin_url = $this->contact->linkedin_url;
        $this->mailing_street = $this->contact->mailing_street;
        $this->mailing_city = $this->contact->mailing_city;
        $this->mailing_state = $this->contact->mailing_state;
        $this->mailing_postal_code = $this->contact->mailing_postal_code;
        $this->mailing_country = $this->contact->mailing_country;
        $this->lead_source = $this->contact->lead_source;
        $this->status = $this->contact->status;
        $this->description = $this->contact->description;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'account_id' => $this->account_id,
            'owner_id' => $this->owner_id ?: auth()->id(),
            'salutation' => $this->salutation,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'email' => $this->email,
            'secondary_email' => $this->secondary_email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'whatsapp' => $this->whatsapp,
            'title' => $this->title,
            'department' => $this->department,
            'birthdate' => $this->birthdate,
            'linkedin_url' => $this->linkedin_url,
            'mailing_street' => $this->mailing_street,
            'mailing_city' => $this->mailing_city,
            'mailing_state' => $this->mailing_state,
            'mailing_postal_code' => $this->mailing_postal_code,
            'mailing_country' => $this->mailing_country,
            'lead_source' => $this->lead_source,
            'status' => $this->status,
            'description' => $this->description,
        ];

        if ($this->isEditMode) {
            $this->contact->update($data);

            session()->flash('success', 'Kişi başarıyla güncellendi.');
            $this->redirect(route('contacts.show', $this->contact), navigate: true);
        } else {
            $contact = Contact::create($data);

            session()->flash('success', 'Kişi başarıyla oluşturuldu.');
            $this->redirect(route('contacts.show', $contact), navigate: true);
        }
    }

    public function toggleAdvanced(): void
    {
        $this->showAdvanced = !$this->showAdvanced;
    }

    public function render()
    {
        $accounts = Account::select('id', 'name')
            ->orderBy('name')
            ->get();

        $users = User::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.contacts.contact-form', [
            'accounts' => $accounts,
            'users' => $users,
        ]);
    }
}