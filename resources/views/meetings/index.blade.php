<x-app-layout>
    <div class="meetings-calendar-page">
        {{-- Header Section --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1 fw-bold">
                    <i class="bi bi-calendar-event text-primary me-2"></i>
                    Toplantı Takvimi
                </h1>
                <p class="text-muted mb-0">Tüm toplantılarınızı görüntüleyin ve yönetin</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMeetingModal">
                <i class="bi bi-plus-circle me-2"></i>
                Yeni Toplantı
            </button>
        </div>

        {{-- Filters Card --}}
        <div class="card modern-card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>
                            Kişi
                        </label>
                        <select class="form-select" id="filterContact">
                            <option value="">Tümü</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact['id'] }}">{{ $contact['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1"></i>
                            Sahip
                        </label>
                        <select class="form-select" id="filterOwner">
                            <option value="">Tümü</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-flag me-1"></i>
                            Öncelik
                        </label>
                        <select class="form-select" id="filterPriority">
                            <option value="">Tümü</option>
                            <option value="high">🔴 Yüksek</option>
                            <option value="medium">🟡 Orta</option>
                            <option value="low">🟢 Düşük</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-check-circle me-1"></i>
                            Durum
                        </label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Tümü</option>
                            <option value="scheduled">Planlandı</option>
                            <option value="completed">Tamamlandı</option>
                            <option value="cancelled">İptal</option>
                            <option value="rescheduled">Ertelendi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-camera-video me-1"></i>
                            Tür
                        </label>
                        <select class="form-select" id="filterMeetingType">
                            <option value="">Tümü</option>
                            <option value="in_person">🤝 Yüz Yüze</option>
                            <option value="online">💻 Online</option>
                            <option value="phone">📞 Telefon</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-outline-secondary btn-sm me-2" id="clearFilters">
                            <i class="bi bi-x-circle me-1"></i>
                            Filtreleri Temizle
                        </button>
                        <button class="btn btn-outline-primary btn-sm" id="todayBtn">
                            <i class="bi bi-calendar-today me-1"></i>
                            Bugün
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar Card --}}
        <div class="card modern-card">
            <div class="card-body p-4">
                <div id="calendar"></div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="card modern-card mt-4">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <span class="fw-semibold me-2">Renk Göstergeleri:</span>
                    <div class="d-flex align-items-center">
                        <span class="badge" style="background-color: #dc3545; width: 20px; height: 20px;"></span>
                        <span class="ms-2">Yüksek Öncelik</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge" style="background-color: #ffc107; width: 20px; height: 20px;"></span>
                        <span class="ms-2">Orta Öncelik</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge" style="background-color: #17a2b8; width: 20px; height: 20px;"></span>
                        <span class="ms-2">Düşük Öncelik</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge" style="background-color: #28a745; width: 20px; height: 20px;"></span>
                        <span class="ms-2">Tamamlandı</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge" style="background-color: #6c757d; width: 20px; height: 20px;"></span>
                        <span class="ms-2">İptal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Meeting Modal --}}
    <div class="modal fade" id="createMeetingModal" tabindex="-1" aria-labelledby="createMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="createMeetingModalLabel">
                        <i class="bi bi-calendar-plus me-2"></i>
                        Yeni Toplantı
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('meetings.meeting-form')
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Meeting Modal --}}
    <div class="modal fade" id="editMeetingModal" tabindex="-1" aria-labelledby="editMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title" id="editMeetingModalLabel">
                        <i class="bi bi-pencil me-2"></i>
                        Toplantıyı Düzenle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMeetingForm">
                        @csrf
                        <input type="hidden" id="editMeetingId">

                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-12">
                                <label for="editTitle" class="form-label fw-semibold">
                                    Toplantı Başlığı <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="editTitle" required>
                            </div>

                            {{-- Meeting Type --}}
                            <div class="col-md-6">
                                <label for="editMeetingType" class="form-label fw-semibold">Toplantı Türü</label>
                                <select class="form-select" id="editMeetingType">
                                    <option value="in_person">🤝 Yüz Yüze</option>
                                    <option value="online">💻 Online</option>
                                    <option value="phone">📞 Telefon</option>
                                </select>
                            </div>

                            {{-- Priority --}}
                            <div class="col-md-6">
                                <label for="editPriority" class="form-label fw-semibold">Öncelik</label>
                                <select class="form-select" id="editPriority">
                                    <option value="low">🟢 Düşük</option>
                                    <option value="medium">🟡 Orta</option>
                                    <option value="high">🔴 Yüksek</option>
                                </select>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-md-6">
                                <label for="editStartTime" class="form-label fw-semibold">
                                    Başlangıç <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="editStartTime" required>
                            </div>

                            {{-- End Time --}}
                            <div class="col-md-6">
                                <label for="editEndTime" class="form-label fw-semibold">
                                    Bitiş <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="editEndTime" required>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="editStatus" class="form-label fw-semibold">Durum</label>
                                <select class="form-select" id="editStatus">
                                    <option value="scheduled">Planlandı</option>
                                    <option value="completed">Tamamlandı</option>
                                    <option value="cancelled">İptal</option>
                                    <option value="rescheduled">Ertelendi</option>
                                </select>
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-6">
                                <label for="editContactId" class="form-label fw-semibold">Kişi</label>
                                <select class="form-select" id="editContactId">
                                    <option value="">Seçiniz</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact['id'] }}">{{ $contact['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Location --}}
                            <div class="col-12" id="editLocationContainer">
                                <label for="editLocation" class="form-label fw-semibold">Konum</label>
                                <input type="text" class="form-control" id="editLocation">
                            </div>

                            {{-- Meeting Link --}}
                            <div class="col-12" id="editMeetingLinkContainer" style="display: none;">
                                <label for="editMeetingLink" class="form-label fw-semibold">Toplantı Linki</label>
                                <input type="url" class="form-control" id="editMeetingLink">
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="editDescription" class="form-label fw-semibold">Açıklama</label>
                                <textarea class="form-control" id="editDescription" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger" id="deleteMeetingBtn">
                                <i class="bi bi-trash me-2"></i>
                                Sil
                            </button>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Güncelle
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        .meetings-calendar-page {
            animation: fadeIn 0.5s ease-in;
        }

        .modern-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

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

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        #calendar {
            max-width: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
            border: none;
            padding: 4px 6px;
        }

        .fc-event:hover {
            opacity: 0.85;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
        }

        .fc-button {
            border-radius: 6px !important;
            text-transform: capitalize !important;
        }

        .fc-daygrid-day-number {
            font-weight: 500;
        }

        .fc-col-header-cell-cushion {
            font-weight: 600;
            color: #495057;
        }
    </style>
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let calendar;

            // Initialize FullCalendar
            function initCalendar() {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    buttonText: {
                        today: 'Bugün',
                        month: 'Ay',
                        week: 'Hafta',
                        day: 'Gün',
                        list: 'Liste'
                    },
                    locale: 'tr',
                    firstDay: 1,
                    height: 'auto',
                    events: function(info, successCallback, failureCallback) {
                        fetchEvents(info, successCallback, failureCallback);
                    },
                    eventClick: function(info) {
                        openEditModal(info.event);
                    },
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                });

                calendar.render();
            }

            // Fetch events with filters
            function fetchEvents(info, successCallback, failureCallback) {
                const filters = {
                    start: info.startStr,
                    end: info.endStr,
                    contact_id: $('#filterContact').val(),
                    owner_id: $('#filterOwner').val(),
                    priority: $('#filterPriority').val(),
                    status: $('#filterStatus').val(),
                    meeting_type: $('#filterMeetingType').val()
                };

                $.ajax({
                    url: '{{ route("meetings.events") }}',
                    method: 'GET',
                    data: filters,
                    success: function(events) {
                        successCallback(events);
                    },
                    error: function() {
                        failureCallback();
                        alert('Toplantılar yüklenirken bir hata oluştu.');
                    }
                });
            }

            // Open edit modal
            function openEditModal(event) {
                const props = event.extendedProps;

                $('#editMeetingId').val(event.id);
                $('#editTitle').val(event.title);
                $('#editDescription').val(props.description || '');
                $('#editStartTime').val(moment(event.start).format('YYYY-MM-DDTHH:mm'));
                $('#editEndTime').val(moment(event.end).format('YYYY-MM-DDTHH:mm'));
                $('#editLocation').val(props.location || '');
                $('#editMeetingType').val(props.meeting_type || 'in_person');
                $('#editMeetingLink').val(props.meeting_link || '');
                $('#editPriority').val(props.priority || 'medium');
                $('#editStatus').val(props.status || 'scheduled');
                $('#editContactId').val(props.contact_id || '');

                toggleLocationFields(props.meeting_type);

                const editModal = new bootstrap.Modal(document.getElementById('editMeetingModal'));
                editModal.show();
            }

            // Toggle location/link fields based on meeting type
            function toggleLocationFields(meetingType) {
                if (meetingType === 'online') {
                    $('#editLocationContainer').hide();
                    $('#editMeetingLinkContainer').show();
                } else {
                    $('#editLocationContainer').show();
                    $('#editMeetingLinkContainer').hide();
                }
            }

            $('#editMeetingType').on('change', function() {
                toggleLocationFields($(this).val());
            });

            // Handle edit form submission
            $('#editMeetingForm').on('submit', function(e) {
                e.preventDefault();

                const meetingId = $('#editMeetingId').val();
                const data = {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    title: $('#editTitle').val(),
                    description: $('#editDescription').val(),
                    start_time: $('#editStartTime').val(),
                    end_time: $('#editEndTime').val(),
                    location: $('#editLocation').val(),
                    meeting_type: $('#editMeetingType').val(),
                    meeting_link: $('#editMeetingLink').val(),
                    priority: $('#editPriority').val(),
                    status: $('#editStatus').val(),
                    contact_id: $('#editContactId').val() || null
                };

                $.ajax({
                    url: `/meetings/${meetingId}`,
                    method: 'PUT',
                    data: data,
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('editMeetingModal')).hide();
                        calendar.refetchEvents();

                        // Show success message
                        const alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="bi bi-check-circle me-2"></i>' + response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                        $('.meetings-calendar-page').prepend(alert);
                        setTimeout(() => alert.fadeOut(), 3000);
                    },
                    error: function(xhr) {
                        alert('Toplantı güncellenirken bir hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
                    }
                });
            });

            // Handle delete
            $('#deleteMeetingBtn').on('click', function() {
                if (!confirm('Bu toplantıyı silmek istediğinizden emin misiniz?')) {
                    return;
                }

                const meetingId = $('#editMeetingId').val();

                $.ajax({
                    url: `/meetings/${meetingId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('editMeetingModal')).hide();
                        calendar.refetchEvents();

                        const alert = $('<div class="alert alert-info alert-dismissible fade show" role="alert">' +
                            '<i class="bi bi-info-circle me-2"></i>' + response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                        $('.meetings-calendar-page').prepend(alert);
                        setTimeout(() => alert.fadeOut(), 3000);
                    },
                    error: function() {
                        alert('Toplantı silinirken bir hata oluştu.');
                    }
                });
            });

            // Filter change handlers
            $('.form-select').on('change', function() {
                calendar.refetchEvents();
            });

            // Clear filters
            $('#clearFilters').on('click', function() {
                $('.form-select').val('');
                calendar.refetchEvents();
            });

            // Today button
            $('#todayBtn').on('click', function() {
                calendar.today();
            });

            // Listen for meeting created/saved events
            document.addEventListener('livewire:init', () => {
                Livewire.on('meetingSaved', () => {
                    bootstrap.Modal.getInstance(document.getElementById('createMeetingModal')).hide();
                    calendar.refetchEvents();

                    const alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="bi bi-check-circle me-2"></i>Toplantı başarıyla oluşturuldu.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    $('.meetings-calendar-page').prepend(alert);
                    setTimeout(() => alert.fadeOut(), 3000);
                });
            });

            // Initialize calendar
            initCalendar();
        });
    </script>
    @endpush
</x-app-layout>
