<div class="lead-form-container">
    <form wire:submit="save" class="modern-form">
        <div class="card modern-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-{{ $isEditing ? 'pencil-square' : 'plus-circle' }} fs-4 me-2"></i>
                    <h5 class="mb-0 fw-bold">{{ $isEditing ? 'Müşteri Adayı Düzenle' : 'Yeni Müşteri Adayı Oluştur' }}</h5>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Personal Information Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Kişisel Bilgiler
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label fw-semibold">
                                Ad <span class="text-danger">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       placeholder="Adınızı girin"
                                       wire:model="first_name">
                                @error('first_name')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label fw-semibold">
                                Soyad <span class="text-danger">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       placeholder="Soyadınızı girin"
                                       wire:model="last_name">
                                @error('last_name')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Information Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        İletişim Bilgileri
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                E-posta <span class="text-danger">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email"
                                       class="form-control form-control-modern @error('email') is-invalid @enderror"
                                       id="email"
                                       placeholder="ornek@email.com"
                                       wire:model="email">
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Telefon</label>
                            <div class="input-with-icon">
                                <i class="bi bi-phone input-icon"></i>
                                <input type="tel"
                                       class="form-control form-control-modern @error('phone') is-invalid @enderror"
                                       id="phone"
                                       placeholder="+90 (5XX) XXX XX XX"
                                       wire:model="phone">
                                @error('phone')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Company Information Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-building text-primary me-2"></i>
                        Şirket Bilgileri
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company" class="form-label fw-semibold">Şirket</label>
                            <div class="input-with-icon">
                                <i class="bi bi-building input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern"
                                       id="company"
                                       placeholder="Şirket adı"
                                       wire:model="company">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold">Unvan</label>
                            <div class="input-with-icon">
                                <i class="bi bi-briefcase input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern"
                                       id="title"
                                       placeholder="İş unvanı"
                                       wire:model="title">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status and Source Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-gear text-primary me-2"></i>
                        Durum ve Kaynak
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="form_status" class="form-label fw-semibold">Durum</label>
                            <select class="form-select form-select-modern @error('status') is-invalid @enderror"
                                    id="form_status"
                                    wire:model="status">
                                <option value="new">🆕 Yeni</option>
                                <option value="contacted">📞 İletişime Geçildi</option>
                                <option value="qualified">✅ Nitelikli</option>
                                <option value="lost">❌ Kaybedildi</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="form_source" class="form-label fw-semibold">Kaynak</label>
                            <select class="form-select form-select-modern @error('source') is-invalid @enderror"
                                    id="form_source"
                                    wire:model="source">
                                <option value="">Seçiniz...</option>
                                <option value="web_form">🌐 Web Formu</option>
                                <option value="google_ads">🎯 Google Ads</option>
                                <option value="facebook_ads">📘 Facebook Ads</option>
                                <option value="instagram_ads">📷 Instagram Ads</option>
                                <option value="linkedin">💼 LinkedIn</option>
                                <option value="referral">👥 Referans</option>
                                <option value="cold_call">📞 Soğuk Arama</option>
                                <option value="trade_show">🎪 Fuar</option>
                                <option value="webinar">🎥 Webinar</option>
                                <option value="content_download">📄 İçerik İndirme</option>
                                <option value="other">📋 Diğer</option>
                            </select>
                            @error('source')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="owner_id" class="form-label fw-semibold">
                                Sahip <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-modern @error('owner_id') is-invalid @enderror"
                                    id="owner_id"
                                    wire:model="owner_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('leads.index') }}"
                       class="btn btn-secondary btn-modern-secondary"
                       wire:navigate>
                        <i class="bi bi-x-circle me-2"></i>
                        İptal
                    </a>
                    <button type="submit" class="btn btn-primary btn-modern-primary">
                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ $isEditing ? 'Güncelle' : 'Kaydet' }}
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Kaydediliyor...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
.lead-form-container {
    animation: fadeIn 0.4s ease-in;
}

.modern-form {
    max-width: 900px;
    margin: 0 auto;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.form-section {
    padding: 1.5rem;
    background-color: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.section-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 1rem;
}

.form-control-modern,
.form-select-modern {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.625rem 0.875rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus,
.form-select-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
}

.input-with-icon {
    position: relative;
}

.input-with-icon .input-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
    z-index: 10;
}

.input-with-icon .form-control {
    padding-right: 40px;
}

.btn-modern-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 0.625rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
}

.btn-modern-secondary {
    border-radius: 8px;
    padding: 0.625rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-modern-secondary:hover {
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush