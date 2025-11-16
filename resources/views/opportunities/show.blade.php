<x-app-layout>
    <div class="opportunity-detail-page">
        {{-- Header Section --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('opportunities.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h2 mb-1 fw-bold d-flex align-items-center">
                        <i class="bi bi-trophy-fill text-warning me-3" style="font-size: 2.5rem;"></i>
                        {{ $opportunity->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        @if($opportunity->account)
                            <i class="bi bi-building me-1"></i>
                            {{ $opportunity->account->name }}
                        @endif
                        <span class="mx-2">•</span>
                        <span class="badge bg-{{ $opportunity->stage === 'closed_won' ? 'success' : ($opportunity->stage === 'closed_lost' ? 'danger' : 'primary') }}">
                            {{ \App\Models\Opportunity::$stages[$opportunity->stage] ?? $opportunity->stage }}
                        </span>
                        <span class="mx-2">•</span>
                        {{ number_format($opportunity->amount, 2) }} {{ $opportunity->currency }}
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                @if($opportunity->stage !== 'closed_won' && $opportunity->stage !== 'closed_lost')
                    <form action="{{ route('opportunities.win', $opportunity) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Kazan
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#loseModal">
                        <i class="bi bi-x-circle me-2"></i>
                        Kaybet
                    </button>
                @endif
                <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Düzenle
                </a>
                <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Bu fırsatı silmek istediğinizden emin misiniz?')">
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
                {{-- Opportunity Details --}}
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            Fırsat Detayları
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Aşama</small>
                                    <span class="badge bg-{{ $opportunity->stage === 'closed_won' ? 'success' : ($opportunity->stage === 'closed_lost' ? 'danger' : 'primary') }} fs-6">
                                        {{ \App\Models\Opportunity::$stages[$opportunity->stage] ?? $opportunity->stage }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Olasılık</small>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 25px;">
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: {{ $opportunity->probability }}%"
                                                 aria-valuenow="{{ $opportunity->probability }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ $opportunity->probability }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-cash me-1"></i>
                                        Tutar
                                    </small>
                                    <span class="fw-semibold fs-5">{{ number_format($opportunity->amount, 2) }} {{ $opportunity->currency }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Ağırlıklı Değer</small>
                                    <span class="fw-semibold">{{ number_format($opportunity->weighted_amount, 2) }} {{ $opportunity->currency }}</span>
                                </div>
                            </div>
                            @if($opportunity->expected_close_date)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Beklenen Kapanış</small>
                                    <span class="fw-semibold">{{ $opportunity->expected_close_date->format('d.m.Y') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($opportunity->actual_close_date)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Gerçek Kapanış</small>
                                    <span class="fw-semibold">{{ $opportunity->actual_close_date->format('d.m.Y') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($opportunity->contact)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">İlgili Kişi</small>
                                    <a href="{{ route('contacts.show', $opportunity->contact) }}" class="fw-semibold text-decoration-none">
                                        {{ $opportunity->contact->full_name }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @if($opportunity->description)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-card-text text-primary me-2"></i>
                            Açıklama
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $opportunity->description }}</p>
                    </div>
                </div>
                @endif

                {{-- Next Steps --}}
                @if($opportunity->next_steps)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-list-check text-primary me-2"></i>
                            Sonraki Adımlar
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $opportunity->next_steps }}</p>
                    </div>
                </div>
                @endif

                {{-- Loss Reason --}}
                @if($opportunity->stage === 'closed_lost' && $opportunity->loss_reason)
                <div class="card modern-card border-danger mb-4">
                    <div class="card-header bg-danger bg-opacity-10 border-0">
                        <h5 class="mb-0 fw-semibold text-danger">
                            <i class="bi bi-x-circle me-2"></i>
                            Kayıp Nedeni
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-danger">{{ $opportunity->loss_reason }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Quick Stats --}}
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h6 class="mb-0 fw-semibold">Özet Bilgiler</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Sahip</small>
                                <span class="fw-semibold">{{ $opportunity->owner->name ?? '-' }}</span>
                            </div>
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                        </div>
                        @if($opportunity->lead_source)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Kaynak</small>
                                <span class="fw-semibold">{{ \App\Models\Opportunity::$sources[$opportunity->lead_source] ?? $opportunity->lead_source }}</span>
                            </div>
                            <i class="bi bi-arrow-down-circle fs-4 text-info"></i>
                        </div>
                        @endif
                        @if($opportunity->sales_cycle_days)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Satış Döngüsü</small>
                                <span class="fw-semibold">{{ $opportunity->sales_cycle_days }} gün</span>
                            </div>
                            <i class="bi bi-clock-history fs-4 text-warning"></i>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">Oluşturulma</small>
                                <span class="fw-semibold">{{ $opportunity->created_at->format('d.m.Y') }}</span>
                            </div>
                            <i class="bi bi-calendar-check fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lose Modal --}}
    <div class="modal fade" id="loseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('opportunities.lose', $opportunity) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Fırsatı Kaybet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="loss_reason" class="form-label">Kayıp Nedeni</label>
                            <textarea class="form-control" id="loss_reason" name="loss_reason" rows="3"
                                      placeholder="Neden kaybedildi?"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-danger">Kayıp Olarak İşaretle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modern-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: box-shadow 0.3s ease;
        }
        .modern-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .info-item {
            padding: 0.5rem 0;
        }
    </style>
</x-app-layout>
