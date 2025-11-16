<x-app-layout>
    {{-- Page Header --}}
    <div class="detail-page-header">
        <div class="header-main">
            <div class="header-avatar">
                {{ strtoupper(substr($contact->first_name, 0, 1)) }}{{ strtoupper(substr($contact->last_name, 0, 1)) }}
            </div>
            <div class="header-info">
                <h1 class="header-title">{{ $contact->full_name }}</h1>
                <div class="header-meta">
                    @if($contact->title)
                        <span class="meta-item">
                            <i class="bi bi-briefcase"></i>
                            {{ $contact->title }}
                        </span>
                    @endif
                    @if($contact->account)
                        <span class="meta-item">
                            <i class="bi bi-building"></i>
                            {{ $contact->account->name }}
                        </span>
                    @endif
                    <span class="meta-badge status-{{ $contact->status }}">
                        <span class="status-dot"></span>
                        {{ ucfirst($contact->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('contacts.edit', $contact) }}" class="btn-action btn-edit">
                <i class="bi bi-pencil"></i>
                <span>Düzenle</span>
            </a>
            <button class="btn-action btn-delete">
                <i class="bi bi-trash"></i>
                <span>Sil</span>
            </button>
        </div>
    </div>

    <div class="detail-page-content">
        {{-- Main Content --}}
        <div class="detail-main">
            {{-- Info Cards --}}
            <div class="info-cards-grid">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">E-posta</div>
                        <div class="info-card-value">
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                    </div>
                </div>

                @if($contact->phone)
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Telefon</div>
                        <div class="info-card-value">
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($contact->mobile)
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Mobil</div>
                        <div class="info-card-value">
                            <a href="tel:{{ $contact->mobile }}">{{ $contact->mobile }}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($contact->department)
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Departman</div>
                        <div class="info-card-value">{{ $contact->department }}</div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Details Section --}}
            <div class="detail-section">
                <div class="section-header-simple">
                    <h3 class="section-title-simple">
                        <i class="bi bi-info-circle"></i>
                        Detaylı Bilgiler
                    </h3>
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Ad Soyad</div>
                        <div class="detail-value">{{ $contact->full_name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Şirket</div>
                        <div class="detail-value">
                            @if($contact->account)
                                <a href="{{ route('accounts.show', $contact->account) }}">
                                    {{ $contact->account->name }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Unvan</div>
                        <div class="detail-value">{{ $contact->title ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Departman</div>
                        <div class="detail-value">{{ $contact->department ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kaynak</div>
                        <div class="detail-value">{{ $contact->lead_source ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Durum</div>
                        <div class="detail-value">
                            <span class="status-badge status-{{ $contact->status }}">
                                <span class="status-dot"></span>
                                {{ ucfirst($contact->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs Section --}}
            <div class="detail-tabs">
                <ul class="nav nav-tabs-modern" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link-modern active" data-bs-toggle="tab" data-bs-target="#activities">
                            <i class="bi bi-clock-history"></i>
                            Aktiviteler
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link-modern" data-bs-toggle="tab" data-bs-target="#notes">
                            <i class="bi bi-sticky"></i>
                            Notlar
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link-modern" data-bs-toggle="tab" data-bs-target="#tasks">
                            <i class="bi bi-check2-square"></i>
                            Görevler
                        </button>
                    </li>
                </ul>
                <div class="tab-content-modern">
                    <div class="tab-pane-modern active" id="activities">
                        <div class="empty-tab-state">
                            <i class="bi bi-clock-history"></i>
                            <p>Henüz aktivite bulunmuyor</p>
                        </div>
                    </div>
                    <div class="tab-pane-modern" id="notes">
                        <div class="empty-tab-state">
                            <i class="bi bi-sticky"></i>
                            <p>Henüz not bulunmuyor</p>
                        </div>
                    </div>
                    <div class="tab-pane-modern" id="tasks">
                        <div class="empty-tab-state">
                            <i class="bi bi-check2-square"></i>
                            <p>Henüz görev bulunmuyor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="detail-sidebar">
            {{-- Owner Card --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <i class="bi bi-person-badge"></i>
                    <span>Sahip</span>
                </div>
                <div class="sidebar-card-body">
                    <div class="owner-info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->owner->name ?? 'NA') }}&background=6366f1&color=fff&size=48"
                             alt="{{ $contact->owner->name ?? 'Atanmamış' }}"
                             class="owner-avatar-large">
                        <div class="owner-details">
                            <div class="owner-name">{{ $contact->owner->name ?? 'Atanmamış' }}</div>
                            <div class="owner-role">{{ $contact->owner->title ?? 'No Title' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline Card --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <i class="bi bi-clock"></i>
                    <span>Zaman Çizelgesi</span>
                </div>
                <div class="sidebar-card-body">
                    <div class="timeline-item">
                        <div class="timeline-label">Oluşturulma</div>
                        <div class="timeline-value">{{ $contact->created_at->format('d M Y, H:i') }}</div>
                        <div class="timeline-ago">{{ $contact->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-label">Son Güncelleme</div>
                        <div class="timeline-value">{{ $contact->updated_at->format('d M Y, H:i') }}</div>
                        <div class="timeline-ago">{{ $contact->updated_at->diffForHumans() }}</div>
                    </div>
                    @if($contact->last_contacted_at)
                    <div class="timeline-item">
                        <div class="timeline-label">Son İletişim</div>
                        <div class="timeline-value">{{ $contact->last_contacted_at->format('d M Y, H:i') }}</div>
                        <div class="timeline-ago">{{ $contact->last_contacted_at->diffForHumans() }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('styles')
<style>
/* Detail Page Styles */
.detail-page-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.header-main {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
}

.header-avatar {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    flex-shrink: 0;
}

.header-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem;
}

.header-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: #64748b;
    font-size: 0.9375rem;
}

.meta-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-edit {
    background: #6366f1;
    color: white;
}

.btn-edit:hover {
    background: #4f46e5;
    transform: translateY(-2px);
    color: white;
}

.btn-delete {
    background: #fee2e2;
    color: #b91c1c;
}

.btn-delete:hover {
    background: #fecaca;
}

/* Detail Page Content */
.detail-page-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 1.5rem;
}

.detail-main {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Info Cards Grid */
.info-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.info-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.info-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.info-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-card-label {
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.info-card-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.info-card-value a {
    color: #6366f1;
    text-decoration: none;
}

.info-card-value a:hover {
    text-decoration: underline;
}

/* Detail Section */
.detail-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

.section-header-simple {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.section-title-simple {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
}

.detail-value {
    font-size: 1rem;
    color: #1e293b;
}

/* Tabs */
.detail-tabs {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.nav-tabs-modern {
    display: flex;
    border-bottom: 2px solid #f1f5f9;
    padding: 0 1.5rem;
    gap: 0.5rem;
}

.nav-link-modern {
    padding: 1.25rem 1.5rem;
    border: none;
    background: none;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
}

.nav-link-modern:hover {
    color: #6366f1;
}

.nav-link-modern.active {
    color: #6366f1;
    border-bottom-color: #6366f1;
}

.tab-content-modern {
    padding: 2rem;
}

.tab-pane-modern {
    display: none;
}

.tab-pane-modern.active {
    display: block;
}

.empty-tab-state {
    text-align: center;
    padding: 3rem;
    color: #94a3b8;
}

.empty-tab-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* Sidebar */
.detail-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.sidebar-card-header {
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #475569;
}

.sidebar-card-body {
    padding: 1.5rem;
}

.owner-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.owner-avatar-large {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}

.owner-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.owner-role {
    font-size: 0.875rem;
    color: #64748b;
}

.timeline-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.timeline-item:last-child {
    border-bottom: none;
}

.timeline-label {
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.timeline-value {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.timeline-ago {
    font-size: 0.8125rem;
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 1024px) {
    .detail-page-content {
        grid-template-columns: 1fr;
    }
    
    .detail-page-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-actions {
        justify-content: stretch;
    }
    
    .btn-action {
        flex: 1;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .header-main {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .info-cards-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush