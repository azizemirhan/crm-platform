<x-app-layout>
    <div class="container-fluid py-4">
        
        {{-- 
            DÜZELTME: Controller'dan gelen $lead değişkenini
            Livewire bileşenine 'leadId' parametresi olarak iletiyoruz.
            Bileşen bu ID'yi aldığında, 'mount' metodu çalışacak 
            ve verileri veritabanından çekecektir.
        --}}
        @livewire('leads.lead-form', ['leadId' => $lead->id])

    </div>
</x-app-layout>