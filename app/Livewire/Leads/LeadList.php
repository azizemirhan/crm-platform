<?php

namespace App\Livewire\Leads;

use App\Models\Lead;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination; // Sayfalama için
use Livewire\Attributes\On; // <-- 1. BU SATIRI EKLEYİN

class LeadList extends Component
{
    use WithPagination; // Laravel'in sayfalama sistemiyle Livewire'ı entegre eder

    /**
     * Filtre değerlerini tutacak dizi.
     * Blade dosyasındaki wire:model'ler buraya bağlanır.
     */
    public $filters = [
        'search' => '',
        'status' => '',
        'source' => '',
        'owner_id' => '',
    ];
    #[On('leadSaved')] // <-- 2. BU SATIRI EKLEYİN
    public function refreshList()
    {
        // Bu metot $dispatch('leadSaved') ile tetiklenir ve
        // bileşenin 'render' metodunu tekrar çalıştırarak listeyi günceller.
    }
    /**
     * Bileşen her güncellendiğinde (filtreler değiştiğinde) bu metot çalışır.
     */
    public function render()
    {
        // 1. Temel Müşteri Adayı sorgusunu başlat
        $query = Lead::with('owner') // "owner" ilişkisini de çek (N+1 problemini önler)
            ->when($this->filters['search'], function ($q, $search) {
                // Arama filtresi
                $q->where(function ($sq) use ($search) {
                    $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%");
                });
            })
            ->when($this->filters['status'], function ($q, $status) {
                // Durum filtresi
                $q->where('status', $status);
            })
            ->when($this->filters['source'], function ($q, $source) {
                // Kaynak filtresi
                $q->where('source', $source);
            })
            ->when($this->filters['owner_id'], function ($q, $owner_id) {
                // Sahip filtresi
                $q->where('owner_id', $owner_id);
            });

        // 2. Filtrelenmiş sorguyu sayfala
        $leads = $query->latest()->paginate(15); // Her sayfada 15 kayıt

        // 3. Filtre dropdown'ı için tüm kullanıcıları al
        $users = User::orderBy('name')->get();

        // 4. Verileri Blade dosyasına gönder
        return view('livewire.leads.lead-list', [
            'leads' => $leads,
            'users' => $users, // <-- Hatanızı çözen kısım budur
        ]);
    }

    /**
     * Filtreler değiştiğinde, kullanıcıyı sayfa 1'e geri gönderir.
     */
    public function updatedFilters()
    {
        $this->resetPage();
    }
    
    /**
     * Silme fonksiyonu (Blade'de çağrılıyor)
     */
    public function deleteLead(Lead $lead)
    {
        // Yetkilendirme eklenebilir
        // $this->authorize('delete', $lead);

        $lead->delete();

        // Başarı mesajı göster
        session()->flash('success', 'Müşteri adayı başarıyla silindi.');
    }
}