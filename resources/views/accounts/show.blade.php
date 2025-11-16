<x-app-layout>
    <div class="account-detail-page">
        {{-- Header Section --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h2 mb-1 fw-bold d-flex align-items-center">
                        <i class="bi bi-building-fill text-primary me-3" style="font-size: 2.5rem;"></i>
                        {{ $account->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        @if($account->industry)
                            <i class="bi bi-briefcase me-1"></i>
                            {{ $account->industry }}
                        @endif
                        @if($account->type)
                            <span class="mx-2">•</span>
                            {{ ucfirst($account->type) }}
                        @endif
                        @if($account->size)
                            <span class="mx-2">•</span>
                            {{ $account->size }} çalışan
                        @endif
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('accounts.edit', $account) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>
                    Düzenle
                </a>
                <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Bu şirketi silmek istediğinizden emin misiniz?')">
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
                {{-- Company Information Card --}}
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-building text-primary me-2"></i>
                            Şirket Bilgileri
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @if($account->legal_name)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Ticari Unvan</small>
                                    <span class="fw-semibold">{{ $account->legal_name }}</span>
                                </div>
                            </div>
                            @endif
                            @if($account->tax_number)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Vergi No</small>
                                    <span class="fw-semibold">{{ $account->tax_number }}</span>
                                </div>
                            </div>
                            @endif
                            @if($account->tax_office)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">Vergi Dairesi</small>
                                    <span class="fw-semibold">{{ $account->tax_office }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-envelope me-1"></i>
                                        E-posta
                                    </small>
                                    @if($account->email)
                                        <a href="mailto:{{ $account->email }}" class="fw-semibold text-decoration-none">
                                            {{ $account->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-telephone me-1"></i>
                                        Telefon
                                    </small>
                                    @if($account->phone)
                                        <a href="tel:{{ $account->phone }}" class="fw-semibold text-decoration-none">
                                            {{ $account->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            @if($account->website)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-globe me-1"></i>
                                        Website
                                    </small>
                                    <a href="{{ $account->website }}" target="_blank" class="fw-semibold text-decoration-none">
                                        {{ $account->website }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Address Information --}}
                @if($account->billing_address_line1 || $account->shipping_address_line1)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            Adres Bilgileri
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($account->billing_address_line1)
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Fatura Adresi</h6>
                                <address class="mb-0">
                                    {{ $account->billing_address_line1 }}<br>
                                    @if($account->billing_address_line2)
                                        {{ $account->billing_address_line2 }}<br>
                                    @endif
                                    {{ $account->billing_city }}
                                    @if($account->billing_state), {{ $account->billing_state }}@endif
                                    {{ $account->billing_postal_code }}<br>
                                    {{ $account->billing_country }}
                                </address>
                            </div>
                            @endif
                            @if($account->shipping_address_line1)
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-3">Sevkiyat Adresi</h6>
                                <address class="mb-0">
                                    {{ $account->shipping_address_line1 }}<br>
                                    @if($account->shipping_address_line2)
                                        {{ $account->shipping_address_line2 }}<br>
                                    @endif
                                    {{ $account->shipping_city }}
                                    @if($account->shipping_state), {{ $account->shipping_state }}@endif
                                    {{ $account->shipping_postal_code }}<br>
                                    {{ $account->shipping_country }}
                                </address>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Description --}}
                @if($account->description)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-card-text text-primary me-2"></i>
                            Açıklama
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $account->description }}</p>
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
                                <span class="fw-semibold">{{ $account->owner->name ?? '-' }}</span>
                            </div>
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                        </div>
                        @if($account->annual_revenue)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Yıllık Gelir</small>
                                <span class="fw-semibold">{{ number_format($account->annual_revenue, 2) }} {{ $account->currency ?? 'TRY' }}</span>
                            </div>
                            <i class="bi bi-cash-coin fs-4 text-success"></i>
                        </div>
                        @endif
                        @if($account->employee_count)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block">Çalışan Sayısı</small>
                                <span class="fw-semibold">{{ $account->employee_count }}</span>
                            </div>
                            <i class="bi bi-people fs-4 text-info"></i>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">Oluşturulma</small>
                                <span class="fw-semibold">{{ $account->created_at->format('d.m.Y') }}</span>
                            </div>
                            <i class="bi bi-calendar-check fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>

                {{-- Social Media --}}
                @if($account->linkedin_url || $account->twitter_handle || $account->facebook_url)
                <div class="card modern-card mb-4">
                    <div class="card-header bg-white border-0">
                        <h6 class="mb-0 fw-semibold">Sosyal Medya</h6>
                    </div>
                    <div class="card-body">
                        @if($account->linkedin_url)
                        <a href="{{ $account->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 mb-2">
                            <i class="bi bi-linkedin me-2"></i>
                            LinkedIn
                        </a>
                        @endif
                        @if($account->twitter_handle)
                        <a href="https://twitter.com/{{ $account->twitter_handle }}" target="_blank" class="btn btn-outline-info btn-sm w-100 mb-2">
                            <i class="bi bi-twitter me-2"></i>
                            Twitter
                        </a>
                        @endif
                        @if($account->facebook_url)
                        <a href="{{ $account->facebook_url }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-facebook me-2"></i>
                            Facebook
                        </a>
                        @endif
                    </div>
                </div>
                @endif
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
