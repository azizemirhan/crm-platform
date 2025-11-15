<?php

namespace App\Livewire\Leads;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LeadForm extends Component
{
    public ?Lead $lead;
    public bool $isEditing = false;
    
    // Form alanları (Blade'deki wire:model'lere bağlanır)
    
    #[Rule('required|string|max:255')]
    public $first_name = '';

    #[Rule('required|string|max:255')]
    public $last_name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('nullable|string|max:255')]
    public $phone = '';

    #[Rule('nullable|string|max:255')]
    public $company = '';

    #[Rule('nullable|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $status = 'new'; // Varsayılan durum

    #[Rule('nullable|string')]
    public $source = '';
    
    #[Rule('required|exists:users,id')]
    public $owner_id;

    // "Sahip" (Owner) dropdown'ını doldurmak için
    public $users = [];

    /**
     * Bileşen yüklendiğinde çalışır.
     * Eğer 'leadId' gelirse, düzenleme modunda açar.
     */
    public function mount(?int $leadId = null)
    {
        // Dropdown için kullanıcıları yükle
        $this->users = User::orderBy('name')->get();

        if ($leadId) {
            $this->lead = Lead::findOrFail($leadId);
            $this->isEditing = true;

            // Formu mevcut verilerle doldur
            $this->first_name = $this->lead->first_name;
            $this->last_name = $this->lead->last_name;
            $this->email = $this->lead->email;
            $this->phone = $this->lead->phone;
            $this->company = $this->lead->company;
            $this->title = $this->lead->title;
            $this->status = $this->lead->status;
            $this->source = $this->lead->source;
            $this->owner_id = $this->lead->owner_id;
        } else {
            // Yeni kayıt, varsayılan sahip olarak giriş yapan kullanıcıyı ata
            $this->lead = new Lead();
            $this->owner_id = Auth::id();
        }
    }

    /**
     * Formu kaydet (Yeni oluştur veya güncelle)
     */
    public function save()
    {
        // Form alanlarını doğrula
        $validatedData = $this->validate();

        if ($this->isEditing) {
            // Güncelle
            $this->lead->update($validatedData);
            session()->flash('success', 'Müşteri adayı başarıyla güncellendi.');
            return $this->redirect(route('leads.show', $this->lead), navigate: true);
        } else {
            // Yeni oluştur - team_id ekle
            $validatedData['team_id'] = Auth::user()->current_team_id ?? 1;
            $newLead = Lead::create($validatedData);
            session()->flash('success', 'Müşteri adayı başarıyla oluşturuldu.');
            return $this->redirect(route('leads.show', $newLead), navigate: true);
        }
    }

    /**
     * Blade dosyasını render et
     */
    public function render()
    {
        return view('livewire.leads.lead-form');
    }
}