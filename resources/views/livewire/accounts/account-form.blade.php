<div>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">{{ $editMode ? 'Şirket Düzenle' : 'Yeni Şirket' }}</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                {{-- Basic Information --}}
                <h5 class="border-bottom pb-2 mb-3">Temel Bilgiler</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Şirket Adı *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ticari Unvan</label>
                        <input type="text" class="form-control" wire:model="legal_name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vergi No</label>
                        <input type="text" class="form-control" wire:model="tax_number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vergi Dairesi</label>
                        <input type="text" class="form-control" wire:model="tax_office">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tür</label>
                        <select class="form-select" wire:model="type">
                            <option value="">Seçiniz</option>
                            <option value="customer">Müşteri</option>
                            <option value="prospect">Potansiyel</option>
                            <option value="partner">Partner</option>
                            <option value="vendor">Tedarikçi</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sahip *</label>
                        <select class="form-select @error('owner_id') is-invalid @enderror" wire:model="owner_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('owner_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Contact Info --}}
                <h5 class="border-bottom pb-2 mb-3">İletişim Bilgileri</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">E-posta</label>
                        <input type="email" class="form-control" wire:model="email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefon</label>
                        <input type="text" class="form-control" wire:model="phone">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Website</label>
                        <input type="url" class="form-control" wire:model="website">
                    </div>
                </div>

                {{-- Company Details --}}
                <h5 class="border-bottom pb-2 mb-3">Şirket Detayları</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Sektör</label>
                        <input type="text" class="form-control" wire:model="industry">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Büyüklük</label>
                        <select class="form-select" wire:model="size">
                            <option value="">Seçiniz</option>
                            <option value="small">Küçük (1-50)</option>
                            <option value="medium">Orta (51-250)</option>
                            <option value="large">Büyük (251-1000)</option>
                            <option value="enterprise">Kurumsal (1000+)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Çalışan Sayısı</label>
                        <input type="number" class="form-control" wire:model="employee_count">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Yıllık Gelir</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" wire:model="annual_revenue">
                            <select class="form-select" style="max-width: 100px;" wire:model="currency">
                                <option value="TRY">TRY</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Billing Address --}}
                <h5 class="border-bottom pb-2 mb-3">Fatura Adresi</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Adres Satırı 1" wire:model="billing_address_line1">
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Adres Satırı 2" wire:model="billing_address_line2">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Şehir" wire:model="billing_city">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="İlçe" wire:model="billing_state">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Posta Kodu" wire:model="billing_postal_code">
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="border-bottom pb-2 mb-0 flex-grow-1">Sevkiyat Adresi</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="copyBillingToShipping">
                        Fatura Adresini Kopyala
                    </button>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Adres Satırı 1" wire:model="shipping_address_line1">
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Adres Satırı 2" wire:model="shipping_address_line2">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Şehir" wire:model="shipping_city">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="İlçe" wire:model="shipping_state">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Posta Kodu" wire:model="shipping_postal_code">
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="form-label">Açıklama</label>
                    <textarea class="form-control" rows="4" wire:model="description"></textarea>
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ $editMode ? 'Güncelle' : 'Kaydet' }}
                    </button>
                    <a href="{{ $editMode ? route('accounts.show', $account) : route('accounts.index') }}" 
                       class="btn btn-secondary" wire:navigate>
                        İptal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
