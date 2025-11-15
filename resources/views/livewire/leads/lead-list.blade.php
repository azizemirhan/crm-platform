<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Müşteri Adayları (Leads)</h1>
            <p class="text-muted mb-0">Tüm potansiyel müşterileri yönetin.</p>
        </div>
        <div>
            <button class="btn btn-primary" wire:click="$dispatch('openModal', { component: 'leads.lead-form' })">
                <i class="bi bi-plus-lg"></i> Yeni Müşteri Adayı Ekle
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="bi bi-filter"></i> Filtreler</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Ara (İsim, E-posta, Şirket)</label>
                    <input type="text" class="form-control" id="search" placeholder="İsim, e-posta veya şirket ara..."
                           wire:model.live.debounce.300ms="filters.search">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Durum</label>
                    <select class="form-select" id="status" wire:model.live="filters.status">
                        <option value="">Tüm Durumlar</option>
                        <option value="new">Yeni</option>
                        <option value="contacted">İletişime Geçildi</option>
                        <option value="qualified">Nitelikli</option>
                        <option value="lost">Kaybedildi</option>
                        <option value="converted">Dönüştürüldü</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="source" class="form-label">Kaynak</label>
                    <select class="form-select" id="source" wire:model.live="filters.source">
                        <option value="">Tüm Kaynaklar</option>
                        <option value="Web Formu">Web Formu</option>
                        <option value="Referans">Referans</option>
                        <option value="Etkinlik">Etkinlik</option>
                        <option value__("Sosyal Medya")>Sosyal Medya</option>
                        <option value="Diğer">Diğer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="owner" class="form-label">Sahip</label>
                    <select class="form-select" id="owner" wire:model.live="filters.owner_id">
                        <option value="">Tüm Sahipler</option>
                        {{-- Burası Livewire component class'ından gelen $users ile doldurulur --}}
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Ad Soyad</th>
                            <th scope="col">Şirket</th>
                            <th scope="col">Durum</th>
                            <th scope="col">Puan</th>
                            <th scope="col">Sahip</th>
                            <th scope="col">E-posta</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr wire:loading.delay>
                            <td colspan="8" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Yükleniyor...</span>
                                </div>
                            </td>
                        </tr>
                        
                        @forelse($leads as $lead)
                            <tr wire:loading.remove>
                                <td>
                                    <a href="{{ route('leads.show', $lead) }}" class="fw-bold text-decoration-none">
                                        {{ $lead->first_name }} {{ $lead->last_name }}
                                    </a>
                                </td>
                                <td>{{ $lead->company }}</td>
                                <td>
                                    <span class="badge {{ $lead->status_color ?? 'bg-secondary' }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td>{{ $lead->score ?? 'N/A' }}</td>
                                <td>{{ $lead->owner->name ?? 'Atanmamış' }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"
                                            wire:click="$dispatch('openModal', { component: 'leads.lead-form', arguments: { leadId: {{ $lead->id }} }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <button class="btn btn-sm btn-outline-danger"
                                            wire:click="deleteLead({{ $lead->id }})"
                                            wire:confirm="Bu müşteri adayını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="8" class="text-center">Filtrelere uygun müşteri adayı bulunamadı.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
</div>