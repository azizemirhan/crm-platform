<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'CRM Platform') }}</title>
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/tr.min.js"></script>

    @livewireStyles
    @stack('styles')
</head>
<body>
    <!-- Primary Sidebar (Icons) -->
    <div class="sidebar-primary">
        <!-- Logo -->
        <div class="sidebar-primary-logo">
            <a href="{{ route('dashboard') }}">
                <img src="/logo1.svg" alt="Logo" class="d-none" id="custom-logo">
                <i class="bi bi-graph-up-arrow text-primary" id="default-logo" style="font-size: 2rem;"></i>
            </a>
        </div>

        <!-- Navigation -->
        <div class="sidebar-primary-nav">
            <a href="{{ route('dashboard') }}" class="sidebar-primary-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-module="home" title="Home">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>

            <a href="#" class="sidebar-primary-item {{ request()->routeIs(['leads.*', 'contacts.*', 'accounts.*', 'opportunities.*', 'calls.*', 'emails.*', 'meetings.*', 'tasks.*']) ? 'active' : '' }}" data-module="sales" title="Sales CRM">
                <i class="bi bi-bag-check"></i>
                <span>Sales</span>
            </a>

            <a href="#" class="sidebar-primary-item" data-module="marketing" title="Marketing">
                <i class="bi bi-megaphone"></i>
                <span>Marketing</span>
            </a>

            <a href="#" class="sidebar-primary-item" data-module="support" title="Customer Support">
                <i class="bi bi-headset"></i>
                <span>Support</span>
            </a>

            <a href="#" class="sidebar-primary-item" data-module="analytics" title="Analytics & Reports">
                <i class="bi bi-graph-up"></i>
                <span>Analytics</span>
            </a>

            <a href="#" class="sidebar-primary-item {{ request()->routeIs('settings.*') ? 'active' : '' }}" data-module="settings" title="Settings">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </div>

        <!-- User Profile (Bottom) -->
        <a href="{{ route('profile.edit') }}" class="sidebar-primary-item" style="margin-top: auto;" title="Profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>
    </div>

    <!-- Secondary Sidebar (Details) -->
    <div class="sidebar-secondary" id="secondarySidebar">
        <!-- HOME MODULE -->
        <div class="sidebar-module" data-module-content="home">
            <div class="sidebar-secondary-header">
                <h5>Home</h5>
            </div>
            <div class="sidebar-secondary-nav">
                <a href="{{ route('dashboard') }}" class="sidebar-secondary-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>

        <!-- SALES CRM MODULE -->
        <div class="sidebar-module active" data-module-content="sales">
            <div class="sidebar-secondary-header">
                <h5>Sales CRM</h5>
                <div class="sidebar-secondary-search position-relative mt-3">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </div>

            <div class="sidebar-secondary-nav">
                <!-- Overview -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Overview</div>
                    <a href="{{ route('dashboard') }}" class="sidebar-secondary-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- CRM -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">CRM</div>
                    <a href="{{ route('leads.index') }}" class="sidebar-secondary-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                        <i class="bi bi-stars"></i>
                        <span>Leads</span>
                    </a>
                    <a href="{{ route('contacts.index') }}" class="sidebar-secondary-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Contacts</span>
                    </a>
                    <a href="{{ route('accounts.index') }}" class="sidebar-secondary-item {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Accounts</span>
                    </a>
                    <a href="{{ route('opportunities.index') }}" class="sidebar-secondary-item {{ request()->routeIs('opportunities.*') ? 'active' : '' }}">
                        <i class="bi bi-trophy"></i>
                        <span>Opportunities</span>
                    </a>
                </div>

                <!-- Activities -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Activities</div>
                    <a href="{{ route('calls.index') }}" class="sidebar-secondary-item {{ request()->routeIs('calls.*') ? 'active' : '' }}">
                        <i class="bi bi-telephone"></i>
                        <span>Calls</span>
                    </a>
                    <a href="{{ route('emails.index') }}" class="sidebar-secondary-item {{ request()->routeIs('emails.*') ? 'active' : '' }}">
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
                    </a>
                </div>

                <!-- Calendar & Planning -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Planning</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-calendar3"></i>
                        <span>Calendar</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-clock-history"></i>
                        <span>Timeline</span>
                    </a>
                </div>

                <!-- Documents -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Documents</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-folder"></i>
                        <span>Files</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Notes</span>
                    </a>
                </div>

                <!-- Reports -->
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Insights</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-bar-chart"></i>
                        <span>Reports</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-graph-up"></i>
                        <span>Forecasting</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MARKETING MODULE -->
        <div class="sidebar-module" data-module-content="marketing">
            <div class="sidebar-secondary-header">
                <h5>Marketing</h5>
            </div>
            <div class="sidebar-secondary-nav">
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Overview</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Campaigns</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-envelope-paper"></i>
                        <span>Email Campaigns</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-chat-dots"></i>
                        <span>SMS Campaigns</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-share"></i>
                        <span>Social Campaigns</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Email Marketing</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-file-earmark-richtext"></i>
                        <span>Templates</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Sequences</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-broadcast"></i>
                        <span>Broadcasts</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Audience</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-list-ul"></i>
                        <span>Lists</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-diagram-3"></i>
                        <span>Segments</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Content</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-file-richtext"></i>
                        <span>Landing Pages</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-ui-checks"></i>
                        <span>Forms</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Social</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-calendar-check"></i>
                        <span>Scheduler</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-chat-square-text"></i>
                        <span>Posts</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Analytics</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-graph-up"></i>
                        <span>Performance</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-bar-chart"></i>
                        <span>Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- SUPPORT MODULE -->
        <div class="sidebar-module" data-module-content="support">
            <div class="sidebar-secondary-header">
                <h5>Customer Support</h5>
            </div>
            <div class="sidebar-secondary-nav">
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Overview</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Tickets</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-ticket-perforated"></i>
                        <span>All Tickets</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-person-check"></i>
                        <span>My Tickets</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-inbox"></i>
                        <span>Unassigned</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Knowledge Base</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-journal-text"></i>
                        <span>Articles</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-folder2-open"></i>
                        <span>Categories</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Communication</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-chat-dots"></i>
                        <span>Live Chat</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-globe"></i>
                        <span>Customer Portal</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Management</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-clock"></i>
                        <span>SLA</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-tag"></i>
                        <span>Labels</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Reports</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-bar-chart"></i>
                        <span>Performance</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-emoji-smile"></i>
                        <span>Satisfaction</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- ANALYTICS MODULE -->
        <div class="sidebar-module" data-module-content="analytics">
            <div class="sidebar-secondary-header">
                <h5>Analytics & Reports</h5>
            </div>
            <div class="sidebar-secondary-nav">
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Overview</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Sales Analytics</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Sales Performance</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-funnel"></i>
                        <span>Pipeline Analysis</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-currency-dollar"></i>
                        <span>Revenue Tracking</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Marketing Analytics</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-bullseye"></i>
                        <span>Campaign Performance</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-people"></i>
                        <span>Lead Generation</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Conversion Funnel</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Team Analytics</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Team Performance</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-activity"></i>
                        <span>Activity Tracking</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Reports</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span>Custom Reports</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-download"></i>
                        <span>Data Export</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Forecasting</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-graph-up"></i>
                        <span>Sales Forecast</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-trophy"></i>
                        <span>Goals & KPIs</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- SETTINGS MODULE -->
        <div class="sidebar-module" data-module-content="settings">
            <div class="sidebar-secondary-header">
                <h5>Settings</h5>
            </div>
            <div class="sidebar-secondary-nav">
                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Personal</div>
                    <a href="{{ route('profile.edit') }}" class="sidebar-secondary-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Organization</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-building"></i>
                        <span>Company Info</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-diagram-3"></i>
                        <span>Teams</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Roles & Permissions</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Integration</div>
                    <a href="{{ route('settings.integrations') }}" class="sidebar-secondary-item {{ request()->routeIs('settings.integrations') ? 'active' : '' }}">
                        <i class="bi bi-puzzle"></i>
                        <span>Integrations</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-envelope-at"></i>
                        <span>Email Config</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-key"></i>
                        <span>API Keys</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Automation</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-diagram-2"></i>
                        <span>Workflows</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-lightning"></i>
                        <span>Rules</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">Customization</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-input-cursor-text"></i>
                        <span>Custom Fields</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-tags"></i>
                        <span>Tags</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-grid-3x3"></i>
                        <span>Categories</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-palette"></i>
                        <span>Theme</span>
                    </a>
                </div>

                <div class="sidebar-secondary-section">
                    <div class="sidebar-secondary-section-title">System</div>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Backup</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-file-text"></i>
                        <span>Audit Logs</span>
                    </a>
                    <a href="#" class="sidebar-secondary-item">
                        <i class="bi bi-database"></i>
                        <span>Data Export</span>
                    </a>
                </div>
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
        <!-- Page Header (if provided) -->
        @isset($header)
            <div class="bg-white border-b border-gray-200 mb-6">
                <div class="py-4">
                    {{ $header }}
                </div>
            </div>
        @endisset

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
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const secondarySidebar = document.getElementById('secondarySidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    secondarySidebar.classList.toggle('show');
                });
            }

            // Module switching
            const primaryItems = document.querySelectorAll('.sidebar-primary-item[data-module]');
            const modules = document.querySelectorAll('.sidebar-module');

            primaryItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    const moduleToShow = this.getAttribute('data-module');

                    // If it's the home link, allow normal navigation
                    if (moduleToShow === 'home') {
                        return;
                    }

                    e.preventDefault();

                    // Remove active class from all primary items
                    primaryItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Hide all modules
                    modules.forEach(m => m.classList.remove('active'));

                    // Show selected module
                    const selectedModule = document.querySelector(`[data-module-content="${moduleToShow}"]`);
                    if (selectedModule) {
                        selectedModule.classList.add('active');
                    }
                });
            });

            // Logo handling
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

    @livewireScripts
</body>
</html>