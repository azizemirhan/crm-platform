<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('super-admin.dashboard') }}" class="text-xl font-bold">🔐 Super Admin Panel</a>
                    <a href="{{ route('super-admin.tenants.index') }}" class="text-gray-300 hover:text-white">← Back to Tenants</a>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('super-admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $tenant->name }}</h1>
            <p class="text-gray-600">{{ $tenant->email }}</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="flex space-x-4">
                <form action="{{ route('super-admin.impersonate', $tenant) }}" method="POST">
                    @csrf
                    <button class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                        🎭 Impersonate User
                    </button>
                </form>

                @if($tenant->status === 'active')
                    <form action="{{ route('super-admin.tenants.suspend', $tenant) }}" method="POST">
                        @csrf
                        <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                            🚫 Suspend Tenant
                        </button>
                    </form>
                @else
                    <form action="{{ route('super-admin.tenants.activate', $tenant) }}" method="POST">
                        @csrf
                        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                            ✅ Activate Tenant
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Tenant Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Tenant Information</h2>
                <dl class="space-y-3">
                    <div><dt class="text-sm text-gray-600">ID:</dt><dd class="font-mono text-sm">{{ $tenant->id }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Name:</dt><dd>{{ $tenant->name }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Email:</dt><dd>{{ $tenant->email }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Domain:</dt><dd class="font-mono text-sm">{{ $tenant->domains->first()->domain ?? 'N/A' }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Schema:</dt><dd class="font-mono text-sm">{{ $tenant->schema_name }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Status:</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($tenant->status) }}</span></dd></div>
                    <div><dt class="text-sm text-gray-600">Plan:</dt><dd><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst($tenant->plan) }}</span></dd></div>
                    <div><dt class="text-sm text-gray-600">Created:</dt><dd>{{ $tenant->created_at->format('Y-m-d H:i') }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Usage & Limits</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Users</span>
                            <span>{{ $usage['users'] }} / {{ $tenant->max_users }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($usage['users'] / $tenant->max_users) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Contacts</span>
                            <span>{{ $usage['contacts'] }} / {{ number_format($tenant->max_contacts) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(($usage['contacts'] / $tenant->max_contacts) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Storage</span>
                            <span>{{ $usage['storage'] }} MB / {{ $tenant->max_storage_mb }} MB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min(($usage['storage'] / $tenant->max_storage_mb) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Telescope Statistics -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">📊 Telescope Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-sm text-blue-600 font-medium">Total Requests</div>
                    <div class="text-2xl font-bold text-blue-900 mt-1">{{ number_format($telescopeStats['total_requests']) }}</div>
                </div>

                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-sm text-green-600 font-medium">Total Queries</div>
                    <div class="text-2xl font-bold text-green-900 mt-1">{{ number_format($telescopeStats['total_queries']) }}</div>
                </div>

                <div class="bg-red-50 rounded-lg p-4">
                    <div class="text-sm text-red-600 font-medium">Total Exceptions</div>
                    <div class="text-2xl font-bold text-red-900 mt-1">{{ number_format($telescopeStats['total_exceptions']) }}</div>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="text-sm text-purple-600 font-medium">Avg Response Time</div>
                    <div class="text-2xl font-bold text-purple-900 mt-1">{{ $telescopeStats['avg_response_time'] }}ms</div>
                </div>
            </div>
        </div>

        <!-- Recent Telescope Entries -->
        @if(count($telescopeEntries) > 0)
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">🔭 Recent Telescope Entries (Last 50)</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Family</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($telescopeEntries as $entry)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $entry->type === 'exception' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $entry->type === 'request' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $entry->type === 'query' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ !in_array($entry->type, ['exception', 'request', 'query']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ $entry->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->family_hash ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="max-w-xs truncate">{{ json_encode($entry->content) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $entry->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Activity Logs -->
        @if(count($activityLogs) > 0)
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">📝 Activity Logs (Last 100)</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Causer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activityLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $log->description ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->subject_type ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->causer_type ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Subscriptions -->
        @if($tenant->subscriptions->count() > 0)
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Subscriptions</h2>
                <div class="space-y-3">
                    @foreach($tenant->subscriptions as $sub)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ ucfirst($sub->plan) }} Plan</p>
                                    <p class="text-sm text-gray-600">${{ $sub->amount }}/{{ $sub->billing_period }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full {{ $sub->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>
