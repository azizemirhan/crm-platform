<div class="opportunity-form-container">
    <form wire:submit="save">
        <div class="row g-3">
            {{-- Name --}}
            <div class="col-12">
                <label for="name" class="form-label fw-semibold">
                    Fırsat Adı <span class="text-danger">*</span>
                </label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       wire:model="name"
                       placeholder="Fırsat adını girin"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Amount --}}
            <div class="col-md-6">
                <label for="amount" class="form-label fw-semibold">
                    Tutar (TRY) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">₺</span>
                    <input type="number"
                           class="form-control @error('amount') is-invalid @enderror"
                           id="amount"
                           wire:model="amount"
                           step="0.01"
                           min="0"
                           placeholder="0.00"
                           required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Probability --}}
            <div class="col-md-6">
                <label for="probability" class="form-label fw-semibold">
                    Başarı Olasılığı (%) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="number"
                           class="form-control @error('probability') is-invalid @enderror"
                           id="probability"
                           wire:model.live="probability"
                           min="0"
                           max="100"
                           required>
                    <span class="input-group-text">%</span>
                    @error('probability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar bg-success"
                         role="progressbar"
                         style="width: {{ $probability }}%"
                         aria-valuenow="{{ $probability }}"
                         aria-valuemin="0"
                         aria-valuemax="100"></div>
                </div>
            </div>

            {{-- Stage --}}
            <div class="col-md-6">
                <label for="stage" class="form-label fw-semibold">Aşama</label>
                <select class="form-select @error('stage') is-invalid @enderror"
                        id="stage"
                        wire:model="stage">
                    <option value="qualification">🔍 Değerlendirme</option>
                    <option value="proposal">📋 Teklif</option>
                    <option value="negotiation">💼 Müzakere</option>
                    <option value="closed_won">✅ Kazanıldı</option>
                    <option value="closed_lost">❌ Kaybedildi</option>
                </select>
                @error('stage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Expected Close Date --}}
            <div class="col-md-6">
                <label for="expected_close_date" class="form-label fw-semibold">
                    Beklenen Kapanış Tarihi <span class="text-danger">*</span>
                </label>
                <input type="date"
                       class="form-control @error('expected_close_date') is-invalid @enderror"
                       id="expected_close_date"
                       wire:model="expected_close_date"
                       required>
                @error('expected_close_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="col-12">
                <label for="description" class="form-label fw-semibold">Açıklama</label>
                <textarea class="form-control"
                          id="description"
                          wire:model="description"
                          rows="3"
                          placeholder="Fırsat detayları, notlar..."></textarea>
            </div>

            {{-- Info Card --}}
            <div class="col-12">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong>Tahmini Değer:</strong>
                        ₺{{ number_format($amount * ($probability / 100), 2, ',', '.') }}
                        (Tutar × Olasılık)
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        İptal
                    </button>
                    <button type="submit" class="btn btn-warning text-white">
                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-trophy me-2"></i>
                            Fırsat Oluştur
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Oluşturuluyor...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('opportunityCreated', () => {
            bootstrap.Modal.getInstance(document.getElementById('opportunityModal')).hide();
            location.reload();
        });
    });
</script>
@endpush
