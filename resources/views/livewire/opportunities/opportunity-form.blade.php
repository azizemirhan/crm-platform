<div>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">{{ $editMode ? 'Fırsat Düzenle' : 'Yeni Fırsat' }}</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label">Fırsat Adı *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Şirket</label>
                        <select class="form-select" wire:model="account_id">
                            <option value="">Seçiniz</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">İlgili Kişi</label>
                        <select class="form-select" wire:model="contact_id">
                            <option value="">Seçiniz</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tutar *</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" wire:model="amount">
                            <select class="form-select" style="max-width: 100px;" wire:model="currency">
                                <option value="TRY">TRY</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                        @error('amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aşama *</label>
                        <select class="form-select @error('stage') is-invalid @enderror" wire:model="stage">
                            @foreach(\App\Models\Opportunity::$stages as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('stage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Olasılık (%) *</label>
                        <input type="number" min="0" max="100" class="form-control" wire:model="probability">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Beklenen Kapanış</label>
                        <input type="date" class="form-control" wire:model="expected_close_date">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kaynak</label>
                        <select class="form-select" wire:model="lead_source">
                            <option value="">Seçiniz</option>
                            @foreach(\App\Models\Opportunity::$sources as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sahip *</label>
                        <select class="form-select" wire:model="owner_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" rows="3" wire:model="description"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Sonraki Adımlar</label>
                        <textarea class="form-control" rows="2" wire:model="next_steps"></textarea>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ $editMode ? 'Güncelle' : 'Kaydet' }}</button>
                    <a href="{{ $editMode ? route('opportunities.show', $opportunity) : route('opportunities.index') }}" class="btn btn-secondary" wire:navigate>İptal</a>
                </div>
            </form>
        </div>
    </div>
</div>
