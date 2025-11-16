<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenants - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('super-admin.dashboard') }}" class="text-xl font-bold">🔐 Super Admin Panel</a>
                    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                    <a href="{{ route('super-admin.tenants.index') }}" class="text-white font-semibold">Tenants</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">{{ auth()->guard('super-admin')->user()->name }}</span>
                    <form action="{{ route('super-admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">All Tenants</h1>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Search tenants..." value="{{ request('search') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">

                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>

                <select name="plan" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Plans</option>
                    <option value="trial" {{ request('plan') == 'trial' ? 'selected' : '' }}>Trial</option>
                    <option value="starter" {{ request('plan') == 'starter' ? 'selected' : '' }}>Starter</option>
                    <option value="professional" {{ request('plan') == 'professional' ? 'selected' : '' }}>Professional</option>
                    <option value="enterprise" {{ request('plan') == 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                </select>

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Filter
                </button>
            </form>
        </div>

        <!-- Tenants List -->
        <div class="bg-white rounded-lg shadow">
            <div class="divide-y divide-gray-200">
                @forelse($tenants as $tenant)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $tenant->name }}</h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($tenant->status) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($tenant->plan) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $tenant->email }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $tenant->domains->first()->domain ?? 'No domain' }} •
                                    Created {{ $tenant->created_at->diffForHumans() }}
                                </p>
                                @if($tenant->activeSubscription)
                                    <p class="text-xs text-gray-500 mt-1">
                                        💰 ${{ $tenant->activeSubscription->amount }}/{{ $tenant->activeSubscription->billing_period }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('super-admin.tenants.show', $tenant) }}"
                                   class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm hover:bg-indigo-200">
                                    View
                                </a>
                                <form action="{{ route('super-admin.impersonate', $tenant) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200">
                                        Impersonate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        <p class="text-xl">No tenants found</p>
                        <p class="text-sm mt-2">Create your first tenant or adjust filters</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($tenants->hasPages())
            <div class="mt-6">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</body>
</html>
