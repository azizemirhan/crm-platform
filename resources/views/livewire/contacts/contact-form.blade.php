<div class="contact-form-container">
    <form wire:submit="save" class="modern-form">
        <div class="card modern-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-{{ $isEditMode ? 'pencil-square' : 'person-plus' }} fs-4 me-2"></i>
                    <h5 class="mb-0 fw-bold">{{ $isEditMode ? 'Kişi Düzenle' : 'Yeni Kişi Oluştur' }}</h5>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Basic Information Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Temel Bilgiler
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="salutation" class="form-label fw-semibold">Ünvan</label>
                            <select class="form-select form-select-modern @error('salutation') is-invalid @enderror"
                                    id="salutation"
                                    wire:model="salutation">
                                <option value="">Seçiniz</option>
                                <option value="Mr">Bay</option>
                                <option value="Mrs">Bayan</option>
                                <option value="Ms">Bn.</option>
                                <option value="Dr">Dr.</option>
                                <option value="Prof">Prof.</option>
                            </select>
                            @error('salutation')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="first_name" class="form-label fw-semibold">
                                İsim <span class="text-danger">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       placeholder="İsim"
                                       wire:model="first_name"
                                       required>
                                @error('first_name')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="last_name" class="form-label fw-semibold">
                                Soyisim <span class="text-danger">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       placeholder="Soyisim"
                                       wire:model="last_name"
                                       required>
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
                                       wire:model="email"
                                       required>
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
                                <i class="bi bi-telephone input-icon"></i>
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
                        <div class="col-md-6">
                            <label for="mobile" class="form-label fw-semibold">Mobil Telefon</label>
                            <div class="input-with-icon">
                                <i class="bi bi-phone input-icon"></i>
                                <input type="tel"
                                       class="form-control form-control-modern"
                                       id="mobile"
                                       placeholder="+90 (5XX) XXX XX XX"
                                       wire:model="mobile">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="secondary_email" class="form-label fw-semibold">İkinci E-posta</label>
                            <div class="input-with-icon">
                                <i class="bi bi-envelope-plus input-icon"></i>
                                <input type="email"
                                       class="form-control form-control-modern"
                                       id="secondary_email"
                                       placeholder="ikinci@email.com"
                                       wire:model="secondary_email">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Professional Information Section --}}
                <div class="form-section mb-4">
                    <h6 class="section-title mb-3">
                        <i class="bi bi-briefcase text-primary me-2"></i>
                        Profesyonel Bilgiler
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold">İş Ünvanı</label>
                            <div class="input-with-icon">
                                <i class="bi bi-person-badge input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern"
                                       id="title"
                                       placeholder="Ör: Satış Müdürü"
                                       wire:model="title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label fw-semibold">Departman</label>
                            <div class="input-with-icon">
                                <i class="bi bi-diagram-3 input-icon"></i>
                                <input type="text"
                                       class="form-control form-control-modern"
                                       id="department"
                                       placeholder="Ör: Satış"
                                       wire:model="department">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="account_id" class="form-label fw-semibold">Şirket</label>
                            <select class="form-select form-select-modern @error('account_id') is-invalid @enderror"
                                    id="account_id"
                                    wire:model="account_id">
                                <option value="">Seçiniz</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="owner_id" class="form-label fw-semibold">Sahip</label>
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

                {{-- Additional Information (Collapsible) --}}
                <div class="form-section mb-4">
                    <button type="button"
                            wire:click="$toggle('showAdvanced')"
                            class="btn btn-link text-decoration-none p-0 mb-3 w-100 text-start">
                        <h6 class="section-title mb-0 d-flex align-items-center justify-content-between">
                            <span>
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Ek Bilgiler
                            </span>
                            <i class="bi bi-chevron-{{ $showAdvanced ? 'up' : 'down' }} text-muted"></i>
                        </h6>
                    </button>

                    @if($showAdvanced)
                        <div class="row g-3 animate-fade-in">
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Durum</label>
                                <select class="form-select form-select-modern"
                                        id="status"
                                        wire:model="status">
                                    <option value="active">✅ Aktif</option>
                                    <option value="inactive">⏸️ Pasif</option>
                                    <option value="disqualified">❌ Niteliksiz</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lead_source" class="form-label fw-semibold">Kaynak</label>
                                <select class="form-select form-select-modern"
                                        id="lead_source"
                                        wire:model="lead_source">
                                    <option value="">Seçiniz</option>
                                    <option value="web_form">🌐 Web Formu</option>
                                    <option value="google_ads">🎯 Google Ads</option>
                                    <option value="facebook_ads">📘 Facebook Ads</option>
                                    <option value="linkedin">💼 LinkedIn</option>
                                    <option value="referral">👥 Referans</option>
                                    <option value="cold_call">📞 Soğuk Arama</option>
                                    <option value="trade_show">🎪 Fuar</option>
                                    <option value="other">📋 Diğer</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="birthdate" class="form-label fw-semibold">Doğum Tarihi</label>
                                <input type="date"
                                       class="form-control form-control-modern"
                                       id="birthdate"
                                       wire:model="birthdate">
                            </div>
                            <div class="col-md-12">
                                <label for="linkedin_url" class="form-label fw-semibold">LinkedIn Profili</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-linkedin input-icon"></i>
                                    <input type="url"
                                           class="form-control form-control-modern"
                                           id="linkedin_url"
                                           placeholder="https://linkedin.com/in/..."
                                           wire:model="linkedin_url">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-semibold">Notlar</label>
                                <textarea class="form-control form-control-modern"
                                          id="description"
                                          rows="3"
                                          placeholder="Kişi hakkında notlar..."
                                          wire:model="description"></textarea>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ $isEditMode && isset($contact) ? route('contacts.show', $contact) : route('contacts.index') }}"
                       class="btn btn-secondary btn-modern-secondary">
                        <i class="bi bi-x-circle me-2"></i>
                        İptal
                    </a>
                    <button type="submit" class="btn btn-primary btn-modern-primary">
                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ $isEditMode ? 'Güncelle' : 'Kaydet' }}
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
.contact-form-container {
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

.animate-fade-in {
    animation: fadeIn 0.3s ease-in;
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
