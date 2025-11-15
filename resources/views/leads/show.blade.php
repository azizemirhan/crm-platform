<x-app-layout>
    {{-- Sayfa Başlığı ve İşlem Butonları --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $lead->first_name }} {{ $lead->last_name }}</h1>
            <p class="text-muted mb-0">
                Müşteri Adayı Detayları 
                <span class="badge {{ $lead->status_color ?? 'bg-secondary' }} ms-2">{{ $lead->status }}</span>
            </p>
        </div>
        <div>
            {{-- 
                Düzenle butonu. Tıpkı ContactForm gibi, 'lead-form' bileşenini
                mevcut leadId ile birlikte bir modal'da açar.
            --}}
            <button class="btn btn-outline-secondary" 
                    wire:click="$dispatch('openModal', { component: 'leads.lead-form', arguments: { leadId: {{ $lead->id }} }})">
                <i class="bi bi-pencil"></i> Düzenle
            </button>
            
            {{-- 
                AŞAMA 2: DÖNÜŞTÜRME BUTONU
                Bu buton, rotanızdaki LeadController@convert metodunu tetikleyecek.
            --}}
            @if($lead->status != 'converted')
                <form action="{{ route('leads.convert', $lead) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success"
                            onclick="return confirm('Bu müşteri adayını dönüştürmek istediğinizden emin misiniz? Bu işlem bir Kişi (Contact) ve Hesap (Account) oluşturacaktır.')">
                        <i class="bi bi-arrow-repeat"></i> Dönüştür
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        {{-- Sol Sütun: Ana Bilgiler --}}
        <div class="col-lg-8">
            {{-- Temel Bilgiler Kartı --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Temel Bilgiler</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Ad Soyad</small>
                            <span class="fw-bold fs-5">{{ $lead->first_name }} {{ $lead->last_name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Şirket</small>
                            <span class="fw-bold fs-5">{{ $lead->company ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">E-posta</small>
                            <span class="fw-bold">{{ $lead->email }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Telefon</small>
                            <span class="fw-bold">{{ $lead->phone ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Unvan</small>
                            <span class="fw-bold">{{ $lead->title ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Web Sitesi</small>
                            <span class="fw-bold">{{ $lead->website ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aktiviteler, Notlar ve Görevler (AŞAMA 3) --}}
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="leadTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="true">Aktiviteler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">Notlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="false">Görevler</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content" id="leadTabsContent">
                    <div class="tab-pane fade show active" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                        <p>Buraya müşteri adayıyla ilgili aktivitelerin (e-posta, telefon görüşmesi) bir listesi gelecek. (Aşama 3)</p>
                        {{-- @livewire('common.activity-feed', ['model' => $lead]) --}}
                    </div>
                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        <p>Buraya müşteri adayıyla ilgili notlar eklenecek ve listelenecek. (Aşama 3)</p>
                        {{-- @livewire('common.note-manager', ['model' => $lead]) --}}
                    </div>
                    <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                        <p>Buraya müşteri adayıyla ilgili "Tekrar Ara" gibi görevler listelenecek. (Aşama 3)</p>
                        {{-- @livewire('common.task-list', ['model' => $lead]) --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sağ Sütun: Durum ve Sahip Bilgisi --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Puan (Score)</small>
                        <span class="fw-bold fs-6">{{ $lead->score ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Kaynak (Source)</small>
                        <span class="fw-bold fs-6">{{ $lead->source ?? 'Bilinmiyor' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Sahip (Owner)</small>
                        <div class="d-flex align-items-center mt-1">
                            {{-- Basit bir avatar --}}
                            <img src="https://ui-avatars.com/api/?name={{ $lead->owner->name ?? 'A' }}&background=random" 
                                 alt="{{ $lead->owner->name ?? 'Atanmamış' }}" 
                                 class="rounded-circle me-2" width="32" height="32">
                            <span class="fw-bold">{{ $lead->owner->name ?? 'Atanmamış' }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block">Oluşturulma Tarihi</small>
                        <span class="fw-bold">{{ $lead->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Son Güncelleme</small>
                        <span class="fw-bold">{{ $lead->updated_at->diffForHumans() }}</span>
                    </div>

                    {{-- Dönüştürülmüşse bilgiyi göster --}}
                    @if($lead->converted_at)
                    <hr>
                    <div class="alert alert-success mb-0">
                        <h6 class="alert-heading">Dönüştürüldü</h6>
                        <p class="mb-0">
                            Bu aday, {{ $lead->converted_at->format('d M Y') }} tarihinde dönüştürüldü.
                        </p>
                        <hr>
                        @if($lead->convertedContact)
                            <p class="mb-1">
                                <strong>Kişi:</strong> 
                                <a href="#">{{ $lead->convertedContact->full_name }}</a>
                            </p>
                        @endif
                        @if($lead->convertedAccount)
                            <p class="mb-0">
                                <strong>Hesap:</strong> 
                                <a href="#">{{ $lead->convertedAccount->name }}</a>
                            </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>