<div class="meeting-form-container">
    <form wire:submit="save">
        <div class="row g-3">
            {{-- Title --}}
            <div class="col-12">
                <label for="title" class="form-label fw-semibold">
                    Toplantı Başlığı <span class="text-danger">*</span>
                </label>
                <input type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       id="title"
                       wire:model="title"
                       placeholder="Örn: Ürün Demo Toplantısı"
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Meeting Type --}}
            <div class="col-md-6">
                <label for="meeting_type" class="form-label fw-semibold">Toplantı Türü</label>
                <select class="form-select @error('meeting_type') is-invalid @enderror"
                        id="meeting_type"
                        wire:model.live="meeting_type">
                    <option value="in_person">🤝 Yüz Yüze</option>
                    <option value="online">💻 Online</option>
                    <option value="phone">📞 Telefon</option>
                </select>
                @error('meeting_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Priority --}}
            <div class="col-md-6">
                <label for="priority" class="form-label fw-semibold">Öncelik</label>
                <select class="form-select @error('priority') is-invalid @enderror"
                        id="priority"
                        wire:model="priority">
                    <option value="low">🟢 Düşük</option>
                    <option value="medium">🟡 Orta</option>
                    <option value="high">🔴 Yüksek</option>
                </select>
                @error('priority')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Start Time --}}
            <div class="col-md-6">
                <label for="start_time" class="form-label fw-semibold">
                    Başlangıç <span class="text-danger">*</span>
                </label>
                <input type="datetime-local"
                       class="form-control @error('start_time') is-invalid @enderror"
                       id="start_time"
                       wire:model="start_time"
                       required>
                @error('start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- End Time --}}
            <div class="col-md-6">
                <label for="end_time" class="form-label fw-semibold">
                    Bitiş <span class="text-danger">*</span>
                </label>
                <input type="datetime-local"
                       class="form-control @error('end_time') is-invalid @enderror"
                       id="end_time"
                       wire:model="end_time"
                       required>
                @error('end_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Location (for in-person) --}}
            @if($meeting_type === 'in_person')
            <div class="col-12">
                <label for="location" class="form-label fw-semibold">Konum</label>
                <input type="text"
                       class="form-control"
                       id="location"
                       wire:model="location"
                       placeholder="Örn: Şirket Ofisi, Toplantı Salonu A">
            </div>
            @endif

            {{-- Meeting Link (for online) --}}
            @if($meeting_type === 'online')
            <div class="col-12">
                <label for="meeting_link" class="form-label fw-semibold">Toplantı Linki</label>
                <input type="url"
                       class="form-control @error('meeting_link') is-invalid @enderror"
                       id="meeting_link"
                       wire:model="meeting_link"
                       placeholder="https://zoom.us/j/...">
                @error('meeting_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endif

            {{-- Description --}}
            <div class="col-12">
                <label for="description" class="form-label fw-semibold">Açıklama</label>
                <textarea class="form-control"
                          id="description"
                          wire:model="description"
                          rows="3"
                          placeholder="Toplantı detayları ve gündem..."></textarea>
            </div>

            {{-- Actions --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        İptal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-check-circle me-2"></i>
                            Kaydet
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Kaydediliyor...
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
        Livewire.on('meetingSaved', () => {
            bootstrap.Modal.getInstance(document.getElementById('meetingModal')).hide();
            location.reload();
        });
    });
</script>
@endpush
