<div>
    {{-- Form, 'save' metodunu tetikler --}}
    <form wire:submit="save">
        {{-- Modal HTML'ini (modal-header, modal-body, modal-footer) 
             Bootstrap Card (kart) yapısıyla değiştiriyoruz. --}}
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $isEditing ? 'Müşteri Adayı Düzenle' : 'Yeni Müşteri Adayı Oluştur' }}</h5>
            </div>
            <div class="card-body">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Ad<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                               wire:model="first_name">
                        @error('first_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Soyad<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                               wire:model="last_name">
                        @error('last_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">E-posta<span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               wire:model="email">
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" wire:model="phone">
                        @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="company" class="form-label">Şirket</label>
                        <input type="text" class="form-control" id="company" wire:model="company">
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label">Unvan</label>
                        <input type="text" class="form-control" id="title" wire:model="title">
                    </div>

                    <div class="col-md-6">
                        <label for="form_status" class="form-label">Durum</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="form_status" wire:model="status">
                            <option value="new">Yeni</option>
                            <option value="contacted">İletişime Geçildi</option>
                            <option value="qualified">Nitelikli</option>
                            <option value="lost">Kaybedildi</option>
                        </select>
                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="form_source" class="form-label">Kaynak</label>
                        <select class="form-select @error('source') is-invalid @enderror" id="form_source" wire:model="source">
                            <option value="">Seçiniz...</option>
                            <option value="Web Formu">Web Formu</option>
                            <option value="Referans">Referans</option>
                            <option value="Etkinlik">Etkinlik</option>
                            <option value="Sosyal Medya">Sosyal Medya</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                        @error('source') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="owner_id" class="form-label">Sahip<span class="text-danger">*</span></label>
                        <select class="form-select @error('owner_id') is-invalid @enderror" id="owner_id" wire:model="owner_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('owner_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>
            <div class="card-footer text-end">
                {{-- İptal butonu liste sayfasına yönlendirir (wire:navigate SPA hissi verir) --}}
                <a href="{{ route('leads.index') }}" class="btn btn-secondary" wire:navigate>İptal</a>
                <button type="submit" class="btn btn-primary">
                    {{-- Kaydederken yükleniyor ikonu göster --}}
                    <span wire:loading.remove wire:target="save">
                        Kaydet
                    </span>
                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </form>
</div>