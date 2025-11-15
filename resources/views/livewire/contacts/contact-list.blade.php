<div class="contact-list-container">
    {{-- Header Section --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="h2 mb-1 fw-bold d-flex align-items-center">
                <i class="bi bi-people-fill text-primary me-2"></i>
                Kişiler
            </h1>
            <p class="text-muted mb-0">Tüm kişileri yönetin ve takip edin</p>
        </div>
        <div>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-modern">
                <i class="bi bi-plus-circle me-2"></i>
                Yeni Kişi Ekle
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stats-card stats-card-primary animate-slide-up">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total'] ?? 0) }}</h3>
                            <p class="text-muted mb-0 small">Toplam Kişi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card stats-card-success animate-slide-up" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['active'] ?? 0) }}</h3>
                            <p class="text-muted mb-0 small">Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card stats-card-info animate-slide-up" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['high_engagement'] ?? 0) }}</h3>
                            <p class="text-muted mb-0 small">Yüksek Etkileşim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Section --}}
    <div class="card modern-card mb-4 animate-fade-in">
        <div class="card-header bg-white border-0">
            <div class="d-flex align-items-center">
                <i class="bi bi-funnel text-primary me-2"></i>
                <h5 class="mb-0 fw-semibold">Filtreler</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label small fw-semibold text-muted">Ara</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="search"
                               placeholder="İsim, e-posta, telefon..."
                               wire:model.live.debounce.300ms="search">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label small fw-semibold text-muted">Durum</label>
                    <select class="form-select" id="status" wire:model.live="status">
                        <option value="">Tümü</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                        <option value="disqualified">Niteliksiz</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label small fw-semibold text-muted">Kaynak</label>
                    <select class="form-select" id="source" wire:model.live="source">
                        <option value="">Tümü</option>
                        <option value="web_form">Web Formu</option>
                        <option value="google_ads">Google Ads</option>
                        <option value="referral">Referans</option>
                        <option value="cold_call">Soğuk Arama</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="clearFilters" type="button" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-circle me-1"></i>
                        Temizle
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="card modern-card animate-fade-in">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle modern-table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="fw-semibold sortable" wire:click="sortBy('first_name')">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person me-1"></i>
                                    İsim
                                    @if($sortBy === 'first_name')
                                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-building me-1"></i>
                                Şirket
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-envelope me-1"></i>
                                İletişim
                            </th>
                            <th scope="col" class="fw-semibold sortable" wire:click="sortBy('engagement_score')">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-graph-up me-1"></i>
                                    Etkileşim
                                    @if($sortBy === 'engagement_score')
                                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>
                                Sahip
                            </th>
                            <th scope="col" class="text-end fw-semibold">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr wire:loading.delay class="loading-row">
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Yükleniyor...</span>
                                </div>
                                <p class="text-muted mt-2 mb-0">Veriler yükleniyor...</p>
                            </td>
                        </tr>

                        @forelse($contacts as $contact)
                            <tr wire:loading.remove class="table-row-hover">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->full_name) }}&background=random&size=40"
                                             alt="{{ $contact->full_name }}"
                                             class="rounded-circle me-2" width="40" height="40">
                                        <div>
                                            <a href="{{ route('contacts.show', $contact) }}"
                                               class="fw-semibold text-decoration-none text-dark hover-primary d-block">
                                                {{ $contact->full_name }}
                                            </a>
                                            @if($contact->title)
                                                <small class="text-muted">{{ $contact->title }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($contact->account)
                                        <span class="text-muted">{{ $contact->account->name }}</span>
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <div class="small">
                                            <i class="bi bi-envelope text-muted me-1"></i>
                                            {{ $contact->email }}
                                        </div>
                                        @if($contact->phone)
                                            <div class="small text-muted">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $contact->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px; max-width: 100px;">
                                            <div class="progress-bar bg-primary"
                                                 role="progressbar"
                                                 style="width: {{ $contact->engagement_score ?? 0 }}%"
                                                 aria-valuenow="{{ $contact->engagement_score ?? 0 }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <span class="fw-semibold small">{{ $contact->engagement_score ?? 0 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->owner->name ?? 'NA') }}&background=random&size=28"
                                             alt="{{ $contact->owner->name ?? 'Atanmamış' }}"
                                             class="rounded-circle me-2" width="28" height="28">
                                        <small class="text-muted">{{ $contact->owner->name ?? 'Atanmamış' }}</small>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('contacts.show', $contact) }}"
                                           class="btn btn-outline-info btn-sm-modern"
                                           data-bs-toggle="tooltip" title="Görüntüle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('contacts.edit', $contact) }}"
                                           class="btn btn-outline-primary btn-sm-modern"
                                           data-bs-toggle="tooltip" title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                                        <h5 class="text-muted">Henüz kişi bulunmuyor</h5>
                                        <p class="text-muted">Yeni bir kişi ekleyerek başlayın</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contacts->hasPages())
                <div class="card-footer bg-white border-top-0">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.contact-list-container {
    animation: fadeIn 0.5s ease-in;
}

.sortable {
    cursor: pointer;
    user-select: none;
    transition: all 0.2s ease;
}

.sortable:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-in;
}

.animate-slide-up {
    animation: slideUp 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.stats-card-primary:hover {
    border-left-color: var(--bs-primary);
}

.stats-card-success:hover {
    border-left-color: var(--bs-success);
}

.stats-card-info:hover {
    border-left-color: var(--bs-info);
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.modern-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.btn-modern {
    border-radius: 8px;
    padding: 10px 24px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.modern-table thead th {
    border-bottom: 2px solid #dee2e6;
    padding: 16px 12px;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.modern-table tbody td {
    padding: 16px 12px;
    vertical-align: middle;
}

.table-row-hover {
    transition: all 0.2s ease;
}

.table-row-hover:hover {
    background-color: rgba(13, 110, 253, 0.03);
    transform: scale(1.01);
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}

.btn-sm-modern {
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-sm-modern:hover {
    transform: scale(1.1);
}

.empty-state i {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.4;
    }
    50% {
        opacity: 0.8;
    }
}

.contact-info {
    font-size: 0.875rem;
    line-height: 1.5;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>
@endpush