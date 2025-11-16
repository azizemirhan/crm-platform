<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0"><i class="bi bi-trophy me-2"></i>Fırsatlar</h2>
        <a href="{{ route('opportunities.create') }}" class="btn btn-primary" wire:navigate>
            <i class="bi bi-plus-circle me-2"></i>Yeni Fırsat
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Toplam</small>
                    <h3>{{ number_format($stats['total']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Açık</small>
                    <h3>{{ number_format($stats['open']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Kazanılan</small>
                    <h3>{{ number_format($stats['won']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Toplam Değer</small>
                    <h3>{{ number_format($stats['total_value'], 0) }} ₺</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Ara..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filters.stage">
                        <option value="">Tüm Aşamalar</option>
                        @foreach(\App\Models\Opportunity::$stages as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filters.owner_id">
                        <option value="">Tüm Sahipler</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" wire:click="clearFilters">Temizle</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th wire:click="sortBy('name')" style="cursor: pointer;">Fırsat</th>
                        <th>Şirket</th>
                        <th>Aşama</th>
                        <th>Tutar</th>
                        <th>Olasılık</th>
                        <th>Sahip</th>
                        <th wire:click="sortBy('expected_close_date')" style="cursor: pointer;">Kapanış</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opp)
                        <tr>
                            <td>
                                <a href="{{ route('opportunities.show', $opp) }}" class="fw-semibold text-decoration-none" wire:navigate>
                                    {{ $opp->name }}
                                </a>
                            </td>
                            <td>{{ $opp->account->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $opp->stage === 'closed_won' ? 'success' : ($opp->stage === 'closed_lost' ? 'danger' : 'primary') }}">
                                    {{ \App\Models\Opportunity::$stages[$opp->stage] ?? $opp->stage }}
                                </span>
                            </td>
                            <td>{{ number_format($opp->amount, 0) }} {{ $opp->currency }}</td>
                            <td>{{ $opp->probability }}%</td>
                            <td>{{ $opp->owner->name ?? '-' }}</td>
                            <td>{{ $opp->expected_close_date?->format('d.m.Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('opportunities.edit', $opp) }}" class="btn btn-sm btn-outline-primary" wire:navigate>
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Fırsat bulunamadı.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($opportunities->hasPages())
            <div class="card-footer">{{ $opportunities->links() }}</div>
        @endif
    </div>
</div>
