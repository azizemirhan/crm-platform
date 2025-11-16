<div>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>
            Şirketler
        </h2>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary" wire:navigate>
            <i class="bi bi-plus-circle me-2"></i>
            Yeni Şirket
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Toplam Şirket</small>
                            <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
                        </div>
                        <i class="bi bi-building fs-1 text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Aktif Müşteriler</small>
                            <h3 class="mb-0">{{ number_format($stats['active']) }}</h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Bu Ay Eklenen</small>
                            <h3 class="mb-0">{{ number_format($stats['this_month']) }}</h3>
                        </div>
                        <i class="bi bi-calendar-plus fs-1 text-info opacity-25"></i>
                    </div>
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
                    <select class="form-select" wire:model.live="filters.type">
                        <option value="">Tüm Tipler</option>
                        <option value="customer">Müşteri</option>
                        <option value="prospect">Potansiyel</option>
                        <option value="partner">Partner</option>
                        <option value="vendor">Tedarikçi</option>
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
                    <button type="button" class="btn btn-outline-secondary w-100" wire:click="clearFilters">
                        <i class="bi bi-x-circle me-1"></i>
                        Temizle
                    </button>
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
                        <th wire:click="sortBy('name')" style="cursor: pointer;">
                            Şirket Adı
                            @if($sortBy === 'name')
                                <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th>Tür</th>
                        <th>Sektör</th>
                        <th>İletişim</th>
                        <th>Sahip</th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                            Oluşturulma
                            @if($sortBy === 'created_at')
                                <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td>
                                <a href="{{ route('accounts.show', $account) }}" class="text-decoration-none fw-semibold" wire:navigate>
                                    <i class="bi bi-building me-2"></i>
                                    {{ $account->name }}
                                </a>
                            </td>
                            <td>
                                @if($account->type)
                                    <span class="badge bg-secondary">{{ ucfirst($account->type) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $account->industry ?? '-' }}</td>
                            <td>
                                @if($account->email)
                                    <a href="mailto:{{ $account->email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-1"></i>
                                    </a>
                                @endif
                                @if($account->phone)
                                    <a href="tel:{{ $account->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>
                                    </a>
                                @endif
                            </td>
                            <td>{{ $account->owner->name ?? '-' }}</td>
                            <td>{{ $account->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-outline-primary" wire:navigate>
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Şirket bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($accounts->hasPages())
            <div class="card-footer">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
</div>
