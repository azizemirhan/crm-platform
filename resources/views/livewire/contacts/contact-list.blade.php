<div class="contact-list-wrapper">
    {{-- Modern Header --}}
    <div class="page-header-modern mb-4">
        <div class="header-content">
            <div class="header-left">
                <div class="page-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h1 class="page-title">Kişiler</h1>
                    <p class="page-subtitle">Tüm müşteri ve iş ortaklarınızı yönetin</p>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('contacts.create') }}" class="btn-create" wire:navigate>
                    <i class="bi bi-plus-circle"></i>
                    <span>Yeni Kişi Ekle</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Modern Stats Cards --}}
    <div class="stats-grid mb-4">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Toplam Kişi</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 15%
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                <div class="stat-label">Aktif</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 10%
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['with_accounts'] ?? 0 }}</div>
                <div class="stat-label">Şirket Bağlantılı</div>
            </div>
            <div class="stat-trend">
                <i class="bi bi-dash"></i> 0%
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['vip'] ?? 0 }}</div>
                <div class="stat-label">VIP Kişiler</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 5%
            </div>
        </div>
    </div>

    {{-- Modern Filters --}}
    <div class="filters-card mb-4">
        <div class="filters-header">
            <h6 class="filters-title">
                <i class="bi bi-funnel-fill"></i>
                Filtreler
            </h6>
            <button class="btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#contactFilters">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="contactFilters">
            <div class="filters-body">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-search"></i> Ara
                    </label>
                    <input type="text" 
                           class="filter-input" 
                           placeholder="İsim, e-posta veya telefon..."
                           wire:model.live.debounce.300ms="filters.search">
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-tag"></i> Durum
                    </label>
                    <select class="filter-select" wire:model.live="filters.status">
                        <option value="">Tümü</option>
                        <option value="active">✅ Aktif</option>
                        <option value="inactive">❌ Pasif</option>
                        <option value="prospect">🎯 Potansiyel</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-building"></i> Şirket
                    </label>
                    <select class="filter-select" wire:model.live="filters.account_id">
                        <option value="">Tüm Şirketler</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-person-badge"></i> Sahip
                    </label>
                    <select class="filter-select" wire:model.live="filters.owner_id">
                        <option value="">Tüm Sahipler</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Modern Table --}}
    <div class="data-table-card">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-person"></i>
                                <span>Kişi</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-building"></i>
                                <span>Şirket</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-briefcase"></i>
                                <span>Unvan</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-tag"></i>
                                <span>Durum</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-person-badge"></i>
                                <span>Sahip</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-envelope"></i>
                                <span>İletişim</span>
                            </div>
                        </th>
                        <th class="text-end">
                            <div class="th-content justify-content-end">
                                <i class="bi bi-gear"></i>
                                <span>İşlemler</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr wire:loading class="loading-row">
                        <td colspan="7">
                            <div class="loading-state">
                                <div class="spinner"></div>
                                <p>Veriler yükleniyor...</p>
                            </div>
                        </td>
                    </tr>

                    @forelse($contacts as $contact)
                        <tr wire:loading.remove class="data-row">
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($contact->first_name, 0, 1)) }}{{ strtoupper(substr($contact->last_name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <a href="{{ route('contacts.show', $contact) }}" class="user-name">
                                            {{ $contact->full_name }}
                                        </a>
                                        <span class="user-subtitle">{{ $contact->department ?? 'No Department' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="company-cell">
                                    <i class="bi bi-building company-icon"></i>
                                    <span>{{ $contact->account->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $contact->title ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $contact->status ?? 'secondary' }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($contact->status ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                <div class="owner-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->owner->name ?? 'NA') }}&background=6366f1&color=fff&size=32"
                                         alt="{{ $contact->owner->name ?? 'Atanmamış' }}"
                                         class="owner-avatar">
                                    <span>{{ $contact->owner->name ?? 'Atanmamış' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="contact-cell">
                                    <div class="contact-item">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $contact->email }}</span>
                                    </div>
                                    @if($contact->phone)
                                        <div class="contact-item">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $contact->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('contacts.show', $contact) }}" 
                                       class="action-btn action-view"
                                       data-bs-toggle="tooltip" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('contacts.edit', $contact) }}" 
                                       class="action-btn action-edit"
                                       wire:navigate
                                       data-bs-toggle="tooltip" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="action-btn action-delete"
                                            wire:click="deleteContact({{ $contact->id }})"
                                            wire:confirm="Bu kişiyi silmek istediğinizden emin misiniz?"
                                            data-bs-toggle="tooltip" title="Sil">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr wire:loading.remove>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h5>Henüz kişi bulunmuyor</h5>
                                    <p>Yeni bir kişi ekleyerek başlayın</p>
                                    <a href="{{ route('contacts.create') }}" class="btn-create btn-create-sm" wire:navigate>
                                        <i class="bi bi-plus-circle"></i>
                                        <span>İlk Kişiyi Ekle</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contacts->hasPages())
            <div class="table-footer">
                <div class="pagination-info">
                    Toplam {{ $contacts->total() }} kayıttan {{ $contacts->firstItem() }}-{{ $contacts->lastItem() }} arası gösteriliyor
                </div>
                <div class="pagination-wrapper">
                    {{ $contacts->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* Contact List styles - Lead list ile aynı CSS'leri kullanıyor */
.contact-list-wrapper {
    animation: fadeIn 0.4s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-modern {
        padding: 1.5rem;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .page-icon {
        display: none;
    }
}
</style>
@endpush