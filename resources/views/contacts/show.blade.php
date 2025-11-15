<x-app-layout>
    <div class="contact-detail-page">
        {{-- Header Section --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h2 mb-1 fw-bold d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->full_name) }}&background=random&size=64"
                             alt="{{ $contact->full_name }}"
                             class="rounded-circle me-3" width="64" height="64">
                        {{ $contact->full_name }}
                    </h1>
                    <p class="text-muted mb-0">
                        {{ $contact->title ?? 'Kişi Detayları' }}
                        @if($contact->account)
                            <span class="mx-2">•</span>
                            <i class="bi bi-building me-1"></i>
                            {{ $contact->account->name }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Düzenle
                </a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Bu kişiyi silmek istediğinizden emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            {{-- Main Information --}}
            <div class="col-lg-8">
                {{-- Contact Information Card --}}
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>
                            İletişim Bilgileri
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-envelope me-1"></i>
                                        E-posta
                                    </small>
                                    <a href="mailto:{{ $contact->email }}" class="fw-semibold text-decoration-none">
                                        {{ $contact->email }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-telephone me-1"></i>
                                        Telefon
                                    </small>
                                    <a href="tel:{{ $contact->phone }}" class="fw-semibold text-decoration-none">
                                        {{ $contact->phone ?? '-' }}
                                    </a>
                                </div>
                            </div>
                            @if($contact->mobile)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-phone me-1"></i>
                                        Mobil
                                    </small>
                                    <span class="fw-semibold">{{ $contact->mobile }}</span>
                                </div>
                            </div>
                            @endif
                            @if($contact->secondary_email)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-envelope-plus me-1"></i>
                                        İkinci E-posta
                                    </small>
                                    <a href="mailto:{{ $contact->secondary_email }}" class="fw-semibold text-decoration-none">
                                        {{ $contact->secondary_email }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Professional Information --}}
                @if($contact->title || $contact->department || $contact->account)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-briefcase text-primary me-2"></i>
                            Profesyonel Bilgiler
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @if($contact->title)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-person-badge me-1"></i>
                                        Unvan
                                    </small>
                                    <span class="fw-semibold">{{ $contact->title }}</span>
                                </div>
                            </div>
                            @endif
                            @if($contact->department)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-diagram-3 me-1"></i>
                                        Departman
                                    </small>
                                    <span class="fw-semibold">{{ $contact->department }}</span>
                                </div>
                            </div>
                            @endif
                            @if($contact->account)
                            <div class="col-md-12">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-building me-1"></i>
                                        Şirket
                                    </small>
                                    <a href="{{ route('accounts.show', $contact->account) }}" class="fw-semibold text-decoration-none">
                                        {{ $contact->account->name }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Activity Timeline --}}
                <div class="card modern-card">
                    <div class="card-header bg-white border-0">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#activities" type="button">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Aktiviteler
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes" type="button">
                                    <i class="bi bi-journal-text me-1"></i>
                                    Notlar
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#opportunities" type="button">
                                    <i class="bi bi-trophy me-1"></i>
                                    Fırsatlar
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="activities">
                                <p class="text-muted text-center py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Henüz aktivite bulunmuyor
                                </p>
                            </div>
                            <div class="tab-pane fade" id="notes">
                                <p class="text-muted text-center py-4">
                                    <i class="bi bi-journal fs-1 d-block mb-2"></i>
                                    Henüz not bulunmuyor
                                </p>
                            </div>
                            <div class="tab-pane fade" id="opportunities">
                                <p class="text-muted text-center py-4">
                                    <i class="bi bi-trophy fs-1 d-block mb-2"></i>
                                    Henüz fırsat bulunmuyor
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Quick Stats --}}
                <div class="card modern-card mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            Genel Bilgiler
                        </h6>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Durum</small>
                            <span class="badge badge-modern badge-{{ $contact->status ?? 'active' }}">
                                {{ ucfirst($contact->status ?? 'active') }}
                            </span>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Etkileşim Skoru</small>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                    <div class="progress-bar bg-primary"
                                         role="progressbar"
                                         style="width: {{ $contact->engagement_score ?? 0 }}%"
                                         aria-valuenow="{{ $contact->engagement_score ?? 0 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <span class="fw-semibold">{{ $contact->engagement_score ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Sahip</small>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->owner->name ?? 'NA') }}&background=random&size=32"
                                     alt="{{ $contact->owner->name ?? 'Atanmamış' }}"
                                     class="rounded-circle me-2" width="32" height="32">
                                <span class="fw-semibold">{{ $contact->owner->name ?? 'Atanmamış' }}</span>
                            </div>
                        </div>
                        @if($contact->lead_source)
                        <div class="info-item mb-3">
                            <small class="text-muted d-block mb-1">Kaynak</small>
                            <span class="fw-semibold">{{ $contact->lead_source }}</span>
                        </div>
                        @endif
                        <hr>
                        <div class="info-item mb-2">
                            <small class="text-muted d-block mb-1">Oluşturulma</small>
                            <span class="small">{{ $contact->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <small class="text-muted d-block mb-1">Son Güncelleme</small>
                            <span class="small">{{ $contact->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="card modern-card">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-lightning text-primary me-2"></i>
                            Hızlı İşlemler
                        </h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope me-2"></i>
                                E-posta Gönder
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="bi bi-telephone me-2"></i>
                                Ara
                            </button>
                            <button class="btn btn-outline-info btn-sm">
                                <i class="bi bi-calendar-plus me-2"></i>
                                Toplantı Planla
                            </button>
                            <button class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-plus-circle me-2"></i>
                                Fırsat Oluştur
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .contact-detail-page {
        animation: fadeIn 0.5s ease-in;
    }

    .info-item {
        transition: all 0.2s ease;
    }

    .info-item:hover {
        transform: translateX(5px);
    }

    .modern-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .modern-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .badge-active {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .badge-inactive {
        background-color: #f5f5f5;
        color: #757575;
    }

    .badge-disqualified {
        background-color: #ffebee;
        color: #d32f2f;
    }
    </style>
    @endpush
</x-app-layout>
