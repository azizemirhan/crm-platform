<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'CRM Platform') }}</title>
<<<<<<< HEAD
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Stack Styles --}}
=======
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/tr.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
>>>>>>> claude/lead-contact-blade-setup-011grna4xFntttFLudh7ViEa
    @stack('styles')
</head>
<body>
    <!-- Primary Sidebar (Icons) -->
    <div class="sidebar-primary">
        <!-- Logo -->
        <div class="sidebar-primary-logo">
            <img src="/logo1.svg" alt="Logo" class="d-none" id="custom-logo">
            <i class="bi bi-graph-up-arrow text-primary" id="default-logo" style="font-size: 2rem;"></i>
        </div>

        <!-- Navigation -->
        <div class="sidebar-primary-nav">
            <a href="#" class="sidebar-primary-item active" data-module="sales">
                <i class="bi bi-bag-check"></i>
                <span>Sales</span>
            </a>
            
            <a href="#" class="sidebar-primary-item" data-module="marketing">
                <i class="bi bi-megaphone"></i>
                <span>Marketing</span>
            </a>
            
            <a href="#" class="sidebar-primary-item" data-module="support">
                <i class="bi bi-headset"></i>
                <span>Support</span>
            </a>
            
            <a href="#" class="sidebar-primary-item" data-module="analytics">
                <i class="bi bi-graph-up"></i>
                <span>Analytics</span>
            </a>
            
            <a href="#" class="sidebar-primary-item" data-module="settings">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </div>

        <!-- User Profile (Bottom) -->
        <div class="sidebar-primary-item" style="margin-top: auto;">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </div>
    </div>

    <!-- Secondary Sidebar (Details) -->
    <div class="sidebar-secondary" id="secondarySidebar">
        <div class="sidebar-secondary-header">
            <h5>Sales</h5>
            
            <!-- Search -->
            <div class="sidebar-secondary-search position-relative mt-3">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Search...">
            </div>
        </div>

        <div class="sidebar-secondary-nav">
            <!-- Dashboard Section -->
            <div class="sidebar-secondary-section">
                <div class="sidebar-secondary-section-title">Overview</div>
                <a href="{{ route('dashboard') }}" class="sidebar-secondary-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- CRM Section -->
            <div class="sidebar-secondary-section">
                <div class="sidebar-secondary-section-title">CRM</div>
                
                <a href="{{ route('leads.index') }}" class="sidebar-secondary-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                    <i class="bi bi-stars"></i>
                    <span>Leads</span>
                    <span class="badge bg-warning text-dark">12</span>
                </a>
<<<<<<< HEAD
                
                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-people"></i>
                    <span>Contacts</span>
                </a>
                
                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-building"></i>
                    <span>Accounts</span>
                </a>
                
                <a href="#" class="sidebar-secondary-item">
=======

                <a href="{{ route('contacts.index') }}" class="sidebar-secondary-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Contacts</span>
                </a>

                <a href="{{ route('accounts.index') }}" class="sidebar-secondary-item {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Accounts</span>
                </a>

                <a href="{{ route('opportunities.index') }}" class="sidebar-secondary-item {{ request()->routeIs('opportunities.*') ? 'active' : '' }}">
>>>>>>> claude/lead-contact-blade-setup-011grna4xFntttFLudh7ViEa
                    <i class="bi bi-trophy"></i>
                    <span>Opportunities</span>
                    <span class="badge bg-success">8</span>
                </a>
            </div>

            <!-- Activities Section -->
            <div class="sidebar-secondary-section">
                <div class="sidebar-secondary-section-title">Activities</div>

                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-telephone"></i>
                    <span>Calls</span>
                </a>

                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-envelope"></i>
                    <span>Emails</span>
                </a>

                <a href="{{ route('meetings.index') }}" class="sidebar-secondary-item {{ request()->routeIs('meetings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i>
                    <span>Meetings</span>
                </a>

                <a href="{{ route('tasks.index') }}" class="sidebar-secondary-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i>
                    <span>Tasks</span>
                    <span class="badge bg-danger">3</span>
                </a>
            </div>

            <!-- Reports Section -->
            <div class="sidebar-secondary-section">
                <div class="sidebar-secondary-section-title">Insights</div>
                
                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-bar-chart"></i>
                    <span>Reports</span>
                </a>
                
                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-pie-chart"></i>
                    <span>Analytics</span>
                </a>
                
                <a href="#" class="sidebar-secondary-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Forecasting</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <!-- Left Side -->
        <div class="d-flex align-items-center">
            <!-- Mobile Menu Toggle -->
            <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>

            <!-- Page Title / Breadcrumb -->
            <div>
                <h5 class="mb-0 fw-semibold">Dashboard</h5>
                <small class="text-muted">Welcome back, {{ Auth::user()->name }}</small>
            </div>
        </div>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-3">
            <!-- Search (Desktop) -->
            <div class="position-relative d-none d-lg-block" style="width: 300px;">
                <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" class="form-control" placeholder="Search anything..." style="padding-left: 2.5rem; border-radius: 8px;">
            </div>

            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-link text-dark position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-bell" style="font-size: 1.25rem;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.625rem;">
                        3
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 320px;">
                    <li class="dropdown-header">Notifications</li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">New lead assigned</a></li>
                    <li><a class="dropdown-item" href="#">Task deadline approaching</a></li>
                    <li><a class="dropdown-item" href="#">Opportunity updated</a></li>
                </ul>
            </div>

            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn btn-link text-dark d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div class="d-none d-md-block text-end">
                        <div class="fw-semibold" style="font-size: 0.875rem;">{{ Auth::user()->name }}</div>
                        <small class="text-muted">{{ Auth::user()->roles->first()?->name ?? 'User' }}</small>
                    </div>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <span class="fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('tenant.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        {{ $slot }}
    </main>

    {{-- Stack Scripts --}}
    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const secondarySidebar = document.getElementById('secondarySidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    secondarySidebar.classList.toggle('show');
                });
            }

            const customLogo = document.getElementById('custom-logo');
            const defaultLogo = document.getElementById('default-logo');
            
            const img = new Image();
            img.src = '/logo1.svg';
            img.onload = function() {
                customLogo.classList.remove('d-none');
                defaultLogo.classList.add('d-none');
            };
        });
    </script>
<<<<<<< HEAD
=======

    @livewireScripts
    @stack('scripts')
>>>>>>> claude/lead-contact-blade-setup-011grna4xFntttFLudh7ViEa
</body>
</html>