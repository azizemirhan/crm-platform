<x-app-layout>
    <div class="tasks-kanban-page">
        {{-- Header Section --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1 fw-bold">
                    <i class="bi bi-check2-square text-primary me-2"></i>
                    Görev Panosu
                </h1>
                <p class="text-muted mb-0">Tüm görevlerinizi yönetin ve takip edin</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                <i class="bi bi-plus-circle me-2"></i>
                Yeni Görev
            </button>
        </div>

        {{-- Filters Card --}}
        <div class="card modern-card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1"></i>
                            Atanan Kişi
                        </label>
                        <select class="form-select" id="filterAssignedTo">
                            <option value="">Tümü</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-flag me-1"></i>
                            Öncelik
                        </label>
                        <select class="form-select" id="filterPriority">
                            <option value="">Tümü</option>
                            <option value="low">🟢 Düşük</option>
                            <option value="medium">🟡 Orta</option>
                            <option value="high">🔴 Yüksek</option>
                            <option value="urgent">⚠️ Acil</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-secondary btn-sm w-100" id="clearFilters">
                            <i class="bi bi-x-circle me-1"></i>
                            Filtreleri Temizle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanban Board --}}
        <div class="kanban-board">
            <div class="kanban-column" data-status="todo">
                <div class="kanban-column-header bg-secondary">
                    <h5 class="mb-0">
                        <i class="bi bi-circle me-2"></i>
                        Yapılacak
                        <span class="badge bg-white text-secondary ms-2" id="count-todo">0</span>
                    </h5>
                </div>
                <div class="kanban-column-body" id="column-todo">
                    <div class="kanban-placeholder">Buraya görev sürükleyin</div>
                </div>
            </div>

            <div class="kanban-column" data-status="in_progress">
                <div class="kanban-column-header bg-primary">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        Devam Ediyor
                        <span class="badge bg-white text-primary ms-2" id="count-in_progress">0</span>
                    </h5>
                </div>
                <div class="kanban-column-body" id="column-in_progress">
                    <div class="kanban-placeholder">Buraya görev sürükleyin</div>
                </div>
            </div>

            <div class="kanban-column" data-status="in_review">
                <div class="kanban-column-header bg-warning">
                    <h5 class="mb-0">
                        <i class="bi bi-eye me-2"></i>
                        İnceleniyor
                        <span class="badge bg-white text-warning ms-2" id="count-in_review">0</span>
                    </h5>
                </div>
                <div class="kanban-column-body" id="column-in_review">
                    <div class="kanban-placeholder">Buraya görev sürükleyin</div>
                </div>
            </div>

            <div class="kanban-column" data-status="completed">
                <div class="kanban-column-header bg-success">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle me-2"></i>
                        Tamamlandı
                        <span class="badge bg-white text-success ms-2" id="count-completed">0</span>
                    </h5>
                </div>
                <div class="kanban-column-body" id="column-completed">
                    <div class="kanban-placeholder">Buraya görev sürükleyin</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Task Modal --}}
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="createTaskModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>
                        Yeni Görev
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="createTitle" class="form-label fw-semibold">
                                    Görev Başlığı <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="createTitle" required>
                            </div>

                            <div class="col-md-6">
                                <label for="createPriority" class="form-label fw-semibold">Öncelik</label>
                                <select class="form-select" id="createPriority">
                                    <option value="low">🟢 Düşük</option>
                                    <option value="medium" selected>🟡 Orta</option>
                                    <option value="high">🔴 Yüksek</option>
                                    <option value="urgent">⚠️ Acil</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="createStatus" class="form-label fw-semibold">Durum</label>
                                <select class="form-select" id="createStatus">
                                    <option value="todo" selected>Yapılacak</option>
                                    <option value="in_progress">Devam Ediyor</option>
                                    <option value="in_review">İnceleniyor</option>
                                    <option value="completed">Tamamlandı</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="createAssignedTo" class="form-label fw-semibold">Atanan Kişi</label>
                                <select class="form-select" id="createAssignedTo">
                                    <option value="">Seçiniz</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="createDueDate" class="form-label fw-semibold">Bitiş Tarihi</label>
                                <input type="date" class="form-control" id="createDueDate">
                            </div>

                            <div class="col-12">
                                <label for="createDescription" class="form-label fw-semibold">Açıklama</label>
                                <textarea class="form-control" id="createDescription" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Task Modal --}}
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title" id="editTaskModalLabel">
                        <i class="bi bi-pencil me-2"></i>
                        Görev Düzenle
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        @csrf
                        <input type="hidden" id="editTaskId">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="editTitle" class="form-label fw-semibold">
                                    Görev Başlığı <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="editTitle" required>
                            </div>

                            <div class="col-md-6">
                                <label for="editPriority" class="form-label fw-semibold">Öncelik</label>
                                <select class="form-select" id="editPriority">
                                    <option value="low">🟢 Düşük</option>
                                    <option value="medium">🟡 Orta</option>
                                    <option value="high">🔴 Yüksek</option>
                                    <option value="urgent">⚠️ Acil</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="editStatus" class="form-label fw-semibold">Durum</label>
                                <select class="form-select" id="editStatus">
                                    <option value="todo">Yapılacak</option>
                                    <option value="in_progress">Devam Ediyor</option>
                                    <option value="in_review">İnceleniyor</option>
                                    <option value="completed">Tamamlandı</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="editAssignedTo" class="form-label fw-semibold">Atanan Kişi</label>
                                <select class="form-select" id="editAssignedTo">
                                    <option value="">Seçiniz</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="editDueDate" class="form-label fw-semibold">Bitiş Tarihi</label>
                                <input type="date" class="form-control" id="editDueDate">
                            </div>

                            <div class="col-12">
                                <label for="editDescription" class="form-label fw-semibold">Açıklama</label>
                                <textarea class="form-control" id="editDescription" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger" id="deleteTaskBtn">
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
    <style>
        .tasks-kanban-page {
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

        /* Kanban Board Styles */
        .kanban-board {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .kanban-board {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .kanban-board {
                grid-template-columns: 1fr;
            }
        }

        .kanban-column {
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 500px;
        }

        .kanban-column-header {
            padding: 15px;
            color: white;
            font-weight: 600;
        }

        .kanban-column-body {
            padding: 15px;
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 400px);
        }

        .kanban-placeholder {
            text-align: center;
            padding: 30px 20px;
            color: #adb5bd;
            font-size: 0.875rem;
            display: none;
        }

        .kanban-column-body:empty .kanban-placeholder {
            display: block;
        }

        .kanban-task-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            cursor: grab;
            transition: all 0.2s ease;
        }

        .kanban-task-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .kanban-task-card.dragging {
            opacity: 0.5;
            cursor: grabbing;
        }

        .kanban-task-title {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .kanban-task-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .kanban-task-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 0.8rem;
        }

        .task-priority {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .task-priority.low {
            background-color: #d4edda;
            color: #155724;
        }

        .task-priority.medium {
            background-color: #fff3cd;
            color: #856404;
        }

        .task-priority.high {
            background-color: #f8d7da;
            color: #721c24;
        }

        .task-priority.urgent {
            background-color: #dc3545;
            color: white;
        }

        .task-due-date {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .task-due-date.overdue {
            color: #dc3545;
            font-weight: 600;
        }

        .task-assignee {
            display: flex;
            align-items: center;
            margin-top: 8px;
        }

        .task-assignee-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            margin-right: 6px;
        }

        .task-assignee-name {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            cursor: grabbing;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tasks = {};

            // Initialize Sortable for each column
            const columns = document.querySelectorAll('.kanban-column-body');
            columns.forEach(column => {
                new Sortable(column, {
                    group: 'kanban',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'dragging',
                    onEnd: function(evt) {
                        handleTaskMove(evt);
                    }
                });
            });

            // Load tasks
            function loadTasks() {
                const filters = {
                    assigned_to: $('#filterAssignedTo').val(),
                    priority: $('#filterPriority').val()
                };

                $.ajax({
                    url: '{{ route("tasks.data") }}',
                    method: 'GET',
                    data: filters,
                    success: function(data) {
                        tasks = data;
                        renderTasks();
                    },
                    error: function() {
                        alert('Görevler yüklenirken bir hata oluştu.');
                    }
                });
            }

            // Render tasks
            function renderTasks() {
                // Clear columns
                $('.kanban-column-body').empty();

                // Render each status
                Object.keys(tasks).forEach(status => {
                    const column = $(`#column-${status}`);
                    const taskList = tasks[status];

                    // Update count
                    $(`#count-${status}`).text(taskList.length);

                    // Render tasks
                    taskList.forEach(task => {
                        column.append(createTaskCard(task));
                    });

                    // Show placeholder if empty
                    if (taskList.length === 0) {
                        column.append('<div class="kanban-placeholder">Buraya görev sürükleyin</div>');
                    }
                });
            }

            // Create task card HTML
            function createTaskCard(task) {
                const priorityLabels = {
                    low: '🟢 Düşük',
                    medium: '🟡 Orta',
                    high: '🔴 Yüksek',
                    urgent: '⚠️ Acil'
                };

                let assigneeHtml = '';
                if (task.assigned_to) {
                    assigneeHtml = `
                        <div class="task-assignee">
                            <div class="task-assignee-avatar">${task.assigned_to.initials}</div>
                            <span class="task-assignee-name">${task.assigned_to.name}</span>
                        </div>
                    `;
                }

                let dueDateHtml = '';
                if (task.due_date) {
                    const dueDateClass = task.is_overdue ? 'overdue' : '';
                    const icon = task.is_overdue ? 'bi-exclamation-triangle' : 'bi-calendar';
                    dueDateHtml = `
                        <div class="task-due-date ${dueDateClass}">
                            <i class="bi ${icon} me-1"></i>
                            ${task.due_date_human}
                        </div>
                    `;
                }

                return `
                    <div class="kanban-task-card" data-task-id="${task.id}" data-task-status="${task.status}">
                        <div class="kanban-task-title">${task.title}</div>
                        ${task.description ? `<div class="kanban-task-description">${task.description}</div>` : ''}
                        <div class="kanban-task-meta">
                            <span class="task-priority ${task.priority}">${priorityLabels[task.priority]}</span>
                            ${dueDateHtml}
                        </div>
                        ${assigneeHtml}
                    </div>
                `;
            }

            // Handle task move
            function handleTaskMove(evt) {
                const taskCard = $(evt.item);
                const taskId = taskCard.data('task-id');
                const newStatus = $(evt.to).attr('id').replace('column-', '');
                const newOrder = evt.newIndex;

                // Update task status
                $.ajax({
                    url: `/tasks/${taskId}/status`,
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus,
                        order: newOrder
                    },
                    success: function() {
                        // Reload tasks to update counts
                        loadTasks();
                    },
                    error: function() {
                        alert('Görev taşınırken bir hata oluştu.');
                        loadTasks(); // Reload to revert
                    }
                });
            }

            // Task card click to edit
            $(document).on('click', '.kanban-task-card', function() {
                const taskId = $(this).data('task-id');
                openEditModal(taskId);
            });

            // Open edit modal
            function openEditModal(taskId) {
                $.ajax({
                    url: `/tasks/${taskId}`,
                    method: 'GET',
                    success: function(task) {
                        $('#editTaskId').val(task.id);
                        $('#editTitle').val(task.title);
                        $('#editDescription').val(task.description || '');
                        $('#editPriority').val(task.priority);
                        $('#editStatus').val(task.status);
                        $('#editAssignedTo').val(task.assigned_to_id || '');
                        $('#editDueDate').val(task.due_date || '');

                        const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                        editModal.show();
                    },
                    error: function() {
                        alert('Görev yüklenirken bir hata oluştu.');
                    }
                });
            }

            // Create task form submission
            $('#createTaskForm').on('submit', function(e) {
                e.preventDefault();

                const data = {
                    _token: '{{ csrf_token() }}',
                    title: $('#createTitle').val(),
                    description: $('#createDescription').val(),
                    priority: $('#createPriority').val(),
                    status: $('#createStatus').val(),
                    assigned_to_id: $('#createAssignedTo').val() || null,
                    due_date: $('#createDueDate').val() || null
                };

                $.ajax({
                    url: '{{ route("tasks.store") }}',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('createTaskModal')).hide();
                        $('#createTaskForm')[0].reset();
                        loadTasks();

                        showAlert('success', response.message);
                    },
                    error: function(xhr) {
                        alert('Görev oluşturulurken bir hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
                    }
                });
            });

            // Edit task form submission
            $('#editTaskForm').on('submit', function(e) {
                e.preventDefault();

                const taskId = $('#editTaskId').val();
                const data = {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    title: $('#editTitle').val(),
                    description: $('#editDescription').val(),
                    priority: $('#editPriority').val(),
                    status: $('#editStatus').val(),
                    assigned_to_id: $('#editAssignedTo').val() || null,
                    due_date: $('#editDueDate').val() || null
                };

                $.ajax({
                    url: `/tasks/${taskId}`,
                    method: 'PUT',
                    data: data,
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
                        loadTasks();

                        showAlert('success', response.message);
                    },
                    error: function(xhr) {
                        alert('Görev güncellenirken bir hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
                    }
                });
            });

            // Delete task
            $('#deleteTaskBtn').on('click', function() {
                if (!confirm('Bu görevi silmek istediğinizden emin misiniz?')) {
                    return;
                }

                const taskId = $('#editTaskId').val();

                $.ajax({
                    url: `/tasks/${taskId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
                        loadTasks();

                        showAlert('info', response.message);
                    },
                    error: function() {
                        alert('Görev silinirken bir hata oluştu.');
                    }
                });
            });

            // Filter change handlers
            $('.form-select').on('change', function() {
                loadTasks();
            });

            // Clear filters
            $('#clearFilters').on('click', function() {
                $('.form-select').val('');
                loadTasks();
            });

            // Show alert message
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
                const icon = type === 'success' ? 'bi-check-circle' : 'bi-info-circle';

                const alert = $(`<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="bi ${icon} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`);

                $('.tasks-kanban-page').prepend(alert);
                setTimeout(() => alert.fadeOut(), 3000);
            }

            // Initial load
            loadTasks();
        });
    </script>
    @endpush
</x-app-layout>
