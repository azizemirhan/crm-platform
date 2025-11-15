<x-app-layout>
    <div class="container-fluid py-4">
        
        {{-- 
            Bu satır, daha önce oluşturduğumuz Livewire bileşenini
            (app/Livewire/Leads/LeadList.php ve 
            resources/views/livewire/leads/lead-list.blade.php) 
            çağırır ve sayfanın içine yerleştirir.
        --}}
        @livewire('leads.lead-list')

    </div>
</x-app-layout>