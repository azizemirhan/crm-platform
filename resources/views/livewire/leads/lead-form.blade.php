<div class="form-wrapper">
    <form wire:submit="save" class="modern-form-container">
        {{-- Form Header --}}
        <div class="form-header">
            <div class="form-header-icon">
                <i class="bi bi-{{ $isEditing ? 'pencil-square' : 'person-plus' }}"></i>
            </div>
            <div class="form-header-content">
                <h2 class="form-title">{{ $isEditing ? 'Müşteri Adayını Düzenle' : 'Yeni Müşteri Adayı' }}</h2>
                <p class="form-subtitle">{{ $isEditing ? 'Bilgileri güncelleyin' : 'Yeni bir potansiyel müşteri ekleyin' }}</p>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="form-body">
            {{-- Personal Information Section --}}
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div>
                        <h3 class="section-title">Kişisel Bilgiler</h3>
                        <p class="section-subtitle">Müşteri adayının temel bilgileri</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Ad
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text"
                                       class="form-input @error('first_name') input-error @enderror"
                                       placeholder="Adınızı girin"
                                       wire:model="first_name">
                            </div>
                            @error('first_name')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Soyad
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text"
                                       class="form-input @error('last_name') input-error @enderror"
                                       placeholder="Soyadınızı girin"
                                       wire:model="last_name">
                            </div>
                            @error('last_name')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information Section --}}
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <h3 class="section-title">İletişim Bilgileri</h3>
                        <p class="section-subtitle">E-posta ve telefon bilgileri</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                E-posta Adresi
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email"
                                       class="form-input @error('email') input-error @enderror"
                                       placeholder="ornek@email.com"
                                       wire:model="email">
                            </div>
                            @error('email')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Telefon Numarası
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <input type="tel"
                                       class="form-input @error('phone') input-error @enderror"
                                       placeholder="+90 (5XX) XXX XX XX"
                                       wire:model="phone">
                            </div>
                            @error('phone')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Company Information Section --}}
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h3 class="section-title">Şirket Bilgileri</h3>
                        <p class="section-subtitle">Çalıştığı şirket ve pozisyon</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Şirket Adı
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text"
                                       class="form-input"
                                       placeholder="Şirket adını girin"
                                       wire:model="company">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Unvan
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <i class="bi bi-briefcase"></i>
                                </span>
                                <input type="text"
                                       class="form-input"
                                       placeholder="İş unvanını girin"
                                       wire:model="title">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            {{-- Status and Assignment Section --}}
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div>
                        <h3 class="section-title">Durum ve Atama</h3>
                        <p class="section-subtitle">Lead durumu ve sorumlu kişi</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Durum
                                <span class="required">*</span>
=======
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
>>>>>>> claude/lead-contact-blade-setup-011grna4xFntttFLudh7ViEa
                            </label>
                            <div class="select-wrapper">
                                <span class="select-icon">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <select class="form-select @error('status') input-error @enderror"
                                        wire:model="status">
                                    <option value="new">🆕 Yeni</option>
                                    <option value="contacted">📞 İletişime Geçildi</option>
                                    <option value="qualified">✅ Nitelikli</option>
                                    <option value="lost">❌ Kaybedildi</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Kaynak
                            </label>
                            <div class="select-wrapper">
                                <span class="select-icon">
                                    <i class="bi bi-diagram-3"></i>
                                </span>
                                <select class="form-select @error('source') input-error @enderror"
                                        wire:model="source">
                                    <option value="">Seçiniz...</option>
                                    <option value="Web Formu">🌐 Web Formu</option>
                                    <option value="Referans">👥 Referans</option>
                                    <option value="Etkinlik">🎯 Etkinlik</option>
                                    <option value="Sosyal Medya">📱 Sosyal Medya</option>
                                    <option value="Diğer">📋 Diğer</option>
                                </select>
                            </div>
                            @error('source')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Sorumlu Kişi
                                <span class="required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <span class="select-icon">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <select class="form-select @error('owner_id') input-error @enderror"
                                        wire:model="owner_id">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('owner_id')
                                <span class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Footer --}}
        <div class="form-footer">
            <a href="{{ route('leads.index') }}" 
               class="btn-secondary"
               wire:navigate>
                <i class="bi bi-x-circle"></i>
                <span>İptal</span>
            </a>
            <button type="submit" class="btn-primary">
                <span wire:loading.remove wire:target="save">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ $isEditing ? 'Güncelle' : 'Kaydet' }}</span>
                </span>
                <span wire:loading wire:target="save" class="loading-content">
                    <span class="spinner-small"></span>
                    <span>Kaydediliyor...</span>
                </span>
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
/* Form Wrapper */
.form-wrapper {
    max-width: 900px;
    margin: 0 auto;
    animation: slideIn 0.4s ease;
}

.modern-form-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* Form Header */
.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    color: white;
}

.form-header-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    flex-shrink: 0;
}

.form-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
}

.form-subtitle {
    margin: 0.5rem 0 0;
    opacity: 0.9;
    font-size: 0.9375rem;
}

/* Form Body */
.form-body {
    padding: 2.5rem;
}

/* Form Section */
.form-section {
    margin-bottom: 2.5rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.section-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.section-subtitle {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0.25rem 0 0;
}

.section-body {
    padding-left: 4rem;
}

/* Form Row */
.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

/* Form Group */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.625rem;
}

.form-label {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.required {
    color: #ef4444;
    font-weight: 700;
}

/* Input Wrapper */
.input-wrapper,
.select-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon,
.select-icon {
    position: absolute;
    left: 1rem;
    color: #94a3b8;
    font-size: 1.125rem;
    pointer-events: none;
    z-index: 1;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9375rem;
    color: #1e293b;
    background: white;
    transition: all 0.3s ease;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-input::placeholder {
    color: #cbd5e1;
}

.input-error {
    border-color: #ef4444 !important;
}

.input-error:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: #ef4444;
    margin-top: 0.25rem;
}

/* Form Footer */
.form-footer {
    padding: 1.75rem 2.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.btn-primary,
.btn-secondary {
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}

.loading-content {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.spinner-small {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .form-header {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
    }

    .form-body {
        padding: 1.5rem;
    }

    .section-header {
        flex-direction: column;
    }

    .section-body {
        padding-left: 0;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-footer {
        padding: 1.25rem 1.5rem;
        flex-direction: column;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush