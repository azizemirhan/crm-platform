<div class="lead-list-wrapper">
    {{-- Modern Header --}}
    <div class="page-header-modern mb-4">
        <div class="header-content">
            <div class="header-left">
                <div class="page-icon">
                    <i class="bi bi-stars"></i>
                </div>
                <div>
                    <h1 class="page-title">Müşteri Adayları</h1>
                    <p class="page-subtitle">Tüm potansiyel müşterileri yönetin ve takip edin</p>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('leads.create') }}" class="btn-create" wire:navigate>
                    <i class="bi bi-plus-circle"></i>
                    <span>Yeni Lead Ekle</span>
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
                <div class="stat-label">Toplam Lead</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 12%
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['qualified'] ?? 0 }}</div>
                <div class="stat-label">Nitelikli</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 8%
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['new'] ?? 0 }}</div>
                <div class="stat-label">Yeni</div>
            </div>
            <div class="stat-trend">
                <i class="bi bi-dash"></i> 0%
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['converted'] ?? 0 }}</div>
                <div class="stat-label">Dönüştürüldü</div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up"></i> 23%
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
            <button class="btn-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="filtersCollapse">
            <div class="filters-body">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-search"></i> Ara
                    </label>
                    <input type="text" 
                           class="filter-input" 
                           placeholder="İsim, e-posta veya şirket..."
                           wire:model.live.debounce.300ms="filters.search">
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-tag"></i> Durum
                    </label>
                    <select class="filter-select" wire:model.live="filters.status">
                        <option value="">Tümü</option>
                        <option value="new">🆕 Yeni</option>
                        <option value="contacted">📞 İletişime Geçildi</option>
                        <option value="qualified">✅ Nitelikli</option>
                        <option value="lost">❌ Kaybedildi</option>
                        <option value="converted">🔄 Dönüştürüldü</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-diagram-3"></i> Kaynak
                    </label>
                    <select class="filter-select" wire:model.live="filters.source">
                        <option value="">Tüm Kaynaklar</option>
                        <option value="Web Formu">🌐 Web Formu</option>
                        <option value="Referans">👥 Referans</option>
                        <option value="Etkinlik">🎯 Etkinlik</option>
                        <option value="Sosyal Medya">📱 Sosyal Medya</option>
                        <option value="Diğer">📋 Diğer</option>
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
                                <span>Müşteri Adayı</span>
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
                                <i class="bi bi-tag"></i>
                                <span>Durum</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="bi bi-star"></i>
                                <span>Puan</span>
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

                    @forelse($leads as $lead)
                        <tr wire:loading.remove class="data-row">
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($lead->first_name, 0, 1)) }}{{ strtoupper(substr($lead->last_name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <a href="{{ route('leads.show', $lead) }}" class="user-name">
                                            {{ $lead->first_name }} {{ $lead->last_name }}
                                        </a>
                                        <span class="user-subtitle">{{ $lead->title ?? 'No Title' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="company-cell">
                                    <i class="bi bi-building company-icon"></i>
                                    <span>{{ $lead->company ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $lead->status ?? 'secondary' }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($lead->status ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                <div class="score-badge">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ $lead->score ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="owner-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->owner->name ?? 'NA') }}&background=6366f1&color=fff&size=32"
                                         alt="{{ $lead->owner->name ?? 'Atanmamış' }}"
                                         class="owner-avatar">
                                    <span>{{ $lead->owner->name ?? 'Atanmamış' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="contact-cell">
                                    <div class="contact-item">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $lead->email }}</span>
                                    </div>
                                    @if($lead->phone)
                                        <div class="contact-item">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $lead->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('leads.show', $lead) }}" 
                                       class="action-btn action-view"
                                       data-bs-toggle="tooltip" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('leads.edit', $lead) }}" 
                                       class="action-btn action-edit"
                                       wire:navigate
                                       data-bs-toggle="tooltip" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="action-btn action-delete"
                                            wire:click="deleteLead({{ $lead->id }})"
                                            wire:confirm="Bu müşteri adayını silmek istediğinizden emin misiniz?"
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
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5>Henüz müşteri adayı bulunmuyor</h5>
                                    <p>Yeni bir müşteri adayı ekleyerek başlayın</p>
                                    <a href="{{ route('leads.create') }}" class="btn-create btn-create-sm" wire:navigate>
                                        <i class="bi bi-plus-circle"></i>
                                        <span>İlk Lead'i Ekle</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->hasPages())
            <div class="table-footer">
                <div class="pagination-info">
                    Toplam {{ $leads->total() }} kayıttan {{ $leads->firstItem() }}-{{ $leads->lastItem() }} arası gösteriliyor
                </div>
                <div class="pagination-wrapper">
                    {{ $leads->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* Lead List Modern Styles */
.lead-list-wrapper {
    animation: fadeIn 0.4s ease;
}

/* Page Header */
.page-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.page-subtitle {
    margin: 0.25rem 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.btn-create {
    background: white;
    color: #667eea;
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    color: #5a67d8;
}

.btn-create-sm {
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
}

.stat-card.stat-primary { color: #6366f1; }
.stat-card.stat-success { color: #10b981; }
.stat-card.stat-warning { color: #f59e0b; }
.stat-card.stat-info { color: #3b82f6; }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background: currentColor;
    opacity: 0.1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: currentColor;
    flex-shrink: 0;
}

.stat-icon i {
    opacity: 1;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-trend {
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #64748b;
}

.stat-trend.up {
    background: #dcfce7;
    color: #16a34a;
}

/* Filters Card */
.filters-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

.filters-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filters-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-filter-toggle {
    background: none;
    border: none;
    color: #64748b;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter-toggle:hover {
    color: #1e293b;
}

.filters-body {
    padding: 1.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-input,
.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    background: white;
}

.filter-input:focus,
.filter-select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Data Table */
.data-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.data-table thead {
    background: #f8fafc;
}

.data-table thead th {
    padding: 1.25rem 1rem;
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    border-bottom: 2px solid #e2e8f0;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.data-table tbody tr {
    transition: all 0.2s ease;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

.data-table tbody td {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f1f5f9;
}

/* User Cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
    text-decoration: none;
    transition: color 0.2s ease;
}

.user-name:hover {
    color: #6366f1;
}

.user-subtitle {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Company Cell */
.company-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #475569;
}

.company-icon {
    color: #94a3b8;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.status-new { background: #dbeafe; color: #1e40af; }
.status-contacted { background: #fef3c7; color: #b45309; }
.status-qualified { background: #dcfce7; color: #15803d; }
.status-lost { background: #fee2e2; color: #b91c1c; }
.status-converted { background: #e9d5ff; color: #7e22ce; }

/* Score Badge */
.score-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: #fef3c7;
    border-radius: 10px;
    color: #b45309;
    font-weight: 600;
    font-size: 0.9375rem;
}

/* Owner Cell */
.owner-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.owner-avatar {
    width: 32px;
    height: 32px;
    border-radius: 8px;
}

/* Contact Cell */
.contact-cell {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #475569;
}

.contact-item i {
    color: #94a3b8;
    font-size: 0.875rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    background: #f8fafc;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.action-btn:hover {
    transform: scale(1.1);
}

.action-view:hover { background: #dbeafe; color: #1e40af; }
.action-edit:hover { background: #fef3c7; color: #b45309; }
.action-delete:hover { background: #fee2e2; color: #b91c1c; }

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #cbd5e1;
}

.empty-state h5 {
    color: #475569;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #94a3b8;
    margin-bottom: 1.5rem;
}

/* Loading State */
.loading-state {
    text-align: center;
    padding: 3rem;
}

.spinner {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    border: 4px solid #f1f5f9;
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Table Footer */
.table-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination-info {
    font-size: 0.875rem;
    color: #64748b;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .filters-body {
        grid-template-columns: 1fr;
    }
    
    .table-footer {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush