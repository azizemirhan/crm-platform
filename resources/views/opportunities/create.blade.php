<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4">
                    <a href="{{ route('opportunities.index') }}" class="btn btn-outline-secondary" wire:navigate>
                        <i class="bi bi-arrow-left me-2"></i>
                        Geri Dön
                    </a>
                </div>
                @livewire('opportunities.opportunity-form')
            </div>
        </div>
    </div>
</x-app-layout>
