<div class="lead-list-container">
    {{-- Header Section --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="h2 mb-1 fw-bold d-flex align-items-center">
                <i class="bi bi-stars text-primary me-2"></i>
                Müşteri Adayları
            </h1>
            <p class="text-muted mb-0">Tüm potansiyel müşterileri yönetin ve takip edin</p>
        </div>
        <div>
            <a href="{{ route('leads.create') }}" class="btn btn-primary btn-modern" wire:navigate>
                <i class="bi bi-plus-circle me-2"></i>
                Yeni Müşteri Adayı
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stats-card stats-card-primary animate-slide-up">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['total'] ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Toplam Lead</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card stats-card-success animate-slide-up" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['qualified'] ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Nitelikli</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card stats-card-warning animate-slide-up" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['new'] ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Yeni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card stats-card-info animate-slide-up" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $stats['converted'] ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Dönüştürüldü</p>
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
                <div class="col-md-4">
                    <label for="search" class="form-label small fw-semibold text-muted">Ara</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="search"
                               placeholder="İsim, e-posta veya şirket..."
                               wire:model.live.debounce.300ms="filters.search">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label small fw-semibold text-muted">Durum</label>
                    <select class="form-select" id="status" wire:model.live="filters.status">
                        <option value="">Tümü</option>
                        <option value="new">Yeni</option>
                        <option value="contacted">İletişime Geçildi</option>
                        <option value="qualified">Nitelikli</option>
                        <option value="lost">Kaybedildi</option>
                        <option value="converted">Dönüştürüldü</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label small fw-semibold text-muted">Kaynak</label>
                    <select class="form-select" id="source" wire:model.live="filters.source">
                        <option value="">Tüm Kaynaklar</option>
                        <option value="Web Formu">Web Formu</option>
                        <option value="Referans">Referans</option>
                        <option value="Etkinlik">Etkinlik</option>
                        <option value="Sosyal Medya">Sosyal Medya</option>
                        <option value="Diğer">Diğer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="owner" class="form-label small fw-semibold text-muted">Sahip</label>
                    <select class="form-select" id="owner" wire:model.live="filters.owner_id">
                        <option value="">Tüm Sahipler</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
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
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-person me-1"></i>
                                Ad Soyad
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-building me-1"></i>
                                Şirket
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-tag me-1"></i>
                                Durum
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-star me-1"></i>
                                Puan
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>
                                Sahip
                            </th>
                            <th scope="col" class="fw-semibold">
                                <i class="bi bi-envelope me-1"></i>
                                İletişim
                            </th>
                            <th scope="col" class="text-end fw-semibold">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr wire:loading.delay class="loading-row">
                            <td colspan="7" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Yükleniyor...</span>
                                </div>
                                <p class="text-muted mt-2 mb-0">Veriler yükleniyor...</p>
                            </td>
                        </tr>

                        @forelse($leads as $lead)
                            <tr wire:loading.remove class="table-row-hover">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ strtoupper(substr($lead->first_name, 0, 1)) }}{{ strtoupper(substr($lead->last_name, 0, 1)) }}
                                        </div>
                                        <a href="{{ route('leads.show', $lead) }}" class="fw-semibold text-decoration-none text-dark hover-primary">
                                            {{ $lead->first_name }} {{ $lead->last_name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $lead->company ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-{{ $lead->status ?? 'secondary' }}">
                                        {{ ucfirst($lead->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="score-badge">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        <span class="fw-semibold">{{ $lead->score ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->owner->name ?? 'NA') }}&background=random&size=32"
                                             alt="{{ $lead->owner->name ?? 'Atanmamış' }}"
                                             class="rounded-circle me-2" width="28" height="28">
                                        <small class="text-muted">{{ $lead->owner->name ?? 'Atanmamış' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <div class="small">
                                            <i class="bi bi-envelope text-muted me-1"></i>
                                            {{ $lead->email }}
                                        </div>
                                        @if($lead->phone)
                                            <div class="small text-muted">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $lead->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('leads.edit', $lead) }}"
                                           class="btn btn-outline-primary btn-sm-modern"
                                           wire:navigate
                                           data-bs-toggle="tooltip" title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm-modern"
                                                wire:click="deleteLead({{ $lead->id }})"
                                                wire:confirm="Bu müşteri adayını silmek istediğinizden emin misiniz?"
                                                data-bs-toggle="tooltip" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                                        <h5 class="text-muted">Henüz müşteri adayı bulunmuyor</h5>
                                        <p class="text-muted">Yeni bir müşteri adayı ekleyerek başlayın</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leads->hasPages())
                <div class="card-footer bg-white border-top-0">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.lead-list-container {
    animation: fadeIn 0.5s ease-in;
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

.stats-card-warning:hover {
    border-left-color: var(--bs-warning);
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

.avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.75rem;
}

.badge-modern {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.75rem;
}

.badge-new {
    background-color: #e3f2fd;
    color: #1976d2;
}

.badge-contacted {
    background-color: #fff3e0;
    color: #f57c00;
}

.badge-qualified {
    background-color: #e8f5e9;
    color: #388e3c;
}

.badge-lost {
    background-color: #ffebee;
    color: #d32f2f;
}

.badge-converted {
    background-color: #f3e5f5;
    color: #7b1fa2;
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

.score-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    background-color: #fff8e1;
    border-radius: 12px;
}

.contact-info {
    font-size: 0.875rem;
    line-height: 1.5;
}
</style>
@endpush