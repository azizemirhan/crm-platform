<x-app-layout>
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div>
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Quick Add
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Contacts -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">Total Contacts</h6>
                            <h2 class="mb-0">1,248</h2>
                            <p class="text-success mb-0">
                                <i class="bi bi-arrow-up"></i> 12% from last month
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Leads -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">Active Leads</h6>
                            <h2 class="mb-0">356</h2>
                            <p class="text-success mb-0">
                                <i class="bi bi-arrow-up"></i> 8% from last month
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-stars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Open Opportunities -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">Open Opportunities</h6>
                            <h2 class="mb-0">84</h2>
                            <p class="text-success mb-0">
                                <i class="bi bi-arrow-up"></i> 15% from last month
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue This Month -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">Revenue</h6>
                            <h2 class="mb-0">₺2.4M</h2>
                            <p class="text-success mb-0">
                                <i class="bi bi-arrow-up"></i> 23% from last month
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Contact</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <i class="bi bi-telephone text-primary"></i>
                                        Initial Discovery Call
                                    </td>
                                    <td>Ali Veli</td>
                                    <td><span class="badge bg-primary">Call</span></td>
                                    <td>2 hours ago</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="bi bi-envelope text-info"></i>
                                        Follow-up Email
                                    </td>
                                    <td>Fatma Şahin</td>
                                    <td><span class="badge bg-info">Email</span></td>
                                    <td>5 hours ago</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar-event text-warning"></i>
                                        Product Demo Meeting
                                    </td>
                                    <td>Can Yılmaz</td>
                                    <td><span class="badge bg-warning">Meeting</span></td>
                                    <td>1 day ago</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="bi bi-chat-dots text-secondary"></i>
                                        WhatsApp Message
                                    </td>
                                    <td>Emre Koç</td>
                                    <td><span class="badge bg-secondary">SMS</span></td>
                                    <td>2 days ago</td>
                                    <td><span class="badge bg-success">Sent</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Upcoming Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <input class="form-check-input me-2 mt-1" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Follow up with pending leads</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> Today, 3:00 PM
                                    </small>
                                </div>
                                <span class="badge bg-danger">High</span>
                            </div>
                        </div>

                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <input class="form-check-input me-2 mt-1" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Send proposal to TechCorp</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> Tomorrow, 10:00 AM
                                    </small>
                                </div>
                                <span class="badge bg-warning">Medium</span>
                            </div>
                        </div>

                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <input class="form-check-input me-2 mt-1" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Review monthly reports</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> Dec 20, 2024
                                    </small>
                                </div>
                                <span class="badge bg-info">Low</span>
                            </div>
                        </div>

                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <input class="form-check-input me-2 mt-1" type="checkbox" checked>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-decoration-line-through">
                                        Update contact database
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-check-circle"></i> Completed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary w-100">
                            View All Tasks <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
