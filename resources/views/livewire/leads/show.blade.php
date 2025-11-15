<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $lead->first_name }} {{ $lead->last_name }}</h1>
            <p class="text-muted mb-0">Müşteri Adayı Detayları</p>
        </div>
        <div>
            @livewire('leads.lead-form', ['leadId' => $lead->id], key($lead->id))
            <button class="btn btn-outline-secondary" wire:click="$dispatch('openModal', { component: 'leads.lead-form', arguments: { leadId: {{ $lead->id }} }})">
                <i class="bi bi-pencil"></i> Düzenle
            </button>
            
            <button class="btn btn-success">
                <i class="bi bi-arrow-repeat"></i> Müşteri Adayını Dönüştür
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Temel Bilgiler</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Ad Soyad</small>
                            <span class="fw-bold">{{ $lead->first_name }} {{ $lead->last_name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Şirket</small>
                            <span class="fw-bold">{{ $lead->company ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">E-posta</small>
                            <span class="fw-bold">{{ $lead->email }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Telefon</small>
                            <span class="fw-bold">{{ $lead->phone ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Unvan</small>
                            <span class="fw-bold">{{ $lead->title ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Web Sitesi</small>
                            <span class="fw-bold">{{ $lead->website ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="leadTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="true">Aktiviteler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">Notlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="false">Görevler</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content" id="leadTabsContent">
                    <div class="tab-pane fade show active" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                        <p>Buraya müşteri adayıyla ilgili aktivitelerin (e-posta, telefon görüşmesi) bir listesi gelecek.</p>
                    </div>
                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        <p>Buraya müşteri adayıyla ilgili notlar eklenecek ve listelenecek.</p>
                    </div>
                    <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                        <p>Buraya müşteri adayıyla ilgili "Tekrar Ara" gibi görevler listelenecek.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Durum</small>
                        <span class="badge fs-6 {{ $lead->status_color ?? 'bg-secondary' }}">
                            {{ $lead->status }}
                        </span>
                    </div>
                     <div class="mb-3">
                        <small class="text-muted d-block">Puan (Score)</small>
                        <span class="fw-bold fs-6">{{ $lead->score ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Kaynak (Source)</small>
                        <span class="fw-bold fs-6">{{ $lead->source ?? 'Bilinmiyor' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Sahip</small>
                        <div class="d-flex align-items-center mt-1">
                            <img src="https://ui-avatars.com/api/?name={{ $lead->owner->name ?? 'A' }}&background=random" alt="{{ $lead->owner->name ?? 'Atanmamış' }}" class="rounded-circle me-2" width="32" height="32">
                            <span class="fw-bold">{{ $lead->owner->name ?? 'Atanmamış' }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block">Oluşturulma Tarihi</small>
                        <span class="fw-bold">{{ $lead->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Son Güncelleme</small>
                        <span class="fw-bold">{{ $lead->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>