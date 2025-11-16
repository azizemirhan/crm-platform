<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Toplam Kişiler</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="bi bi-people-fill text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Bu Ay Eklenen</div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['this_month'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="bi bi-person-plus-fill text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Şirket Bağlantılı</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['with_accounts'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="bi bi-building text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-600 mb-1">VIP Kişiler</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['vip'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="bi bi-star-fill text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Filters -->
        <div class="p-6 border-b bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-search text-gray-400"></i>
                        </div>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="İsim, e-posta veya telefon ara...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model.live="filters.status"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                        <option value="">Tüm Durumlar</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                        <option value="potential">Potansiyel</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <select wire:model.live="filters.type"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                        <option value="">Tüm Tipler</option>
                        <option value="customer">Müşteri</option>
                        <option value="prospect">Potansiyel</option>
                        <option value="partner">Partner</option>
                        <option value="supplier">Tedarikçi</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters Toggle -->
            <div class="mt-4">
                <button wire:click="$toggle('showAdvancedFilters')"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="bi {{ $showAdvancedFilters ? 'bi-chevron-up' : 'bi-chevron-down' }} mr-1"></i>
                    {{ $showAdvancedFilters ? 'Gelişmiş Filtreleri Gizle' : 'Gelişmiş Filtreleri Göster' }}
                </button>
            </div>

            <!-- Advanced Filters -->
            @if($showAdvancedFilters)
                <div class="mt-4 pt-4 border-t grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Source Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kaynak</label>
                        <select wire:model.live="filters.source"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="">Tümü</option>
                            <option value="website">Website</option>
                            <option value="referral">Referans</option>
                            <option value="social_media">Sosyal Medya</option>
                            <option value="event">Etkinlik</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>

                    <!-- Industry Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sektör</label>
                        <select wire:model.live="filters.industry"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="">Tümü</option>
                            <option value="technology">Teknoloji</option>
                            <option value="finance">Finans</option>
                            <option value="healthcare">Sağlık</option>
                            <option value="retail">Perakende</option>
                            <option value="manufacturing">İmalat</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>

                    <!-- Owner Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sorumlu</label>
                        <select wire:model.live="filters.owner_id"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="">Tümü</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Reset Filters -->
                <div class="mt-4">
                    <button wire:click="resetFilters"
                            class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class="bi bi-arrow-counterclockwise mr-1"></i>
                        Filtreleri Sıfırla
                    </button>
                </div>
            @endif
        </div>

        <!-- Table Header -->
        <div class="px-6 py-4 bg-white border-b flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-700">
                    <span class="font-medium">{{ $contacts->total() }}</span> kişi bulundu
                </span>
            </div>

            <div class="flex items-center space-x-2">
                <!-- View Toggle -->
                <div class="inline-flex rounded-lg shadow-sm" role="group">
                    <button wire:click="$set('viewMode', 'grid')"
                            class="px-4 py-2 text-sm font-medium {{ $viewMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} border border-gray-200 rounded-l-lg">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </button>
                    <button wire:click="$set('viewMode', 'list')"
                            class="px-4 py-2 text-sm font-medium {{ $viewMode === 'list' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} border border-gray-200 rounded-r-lg">
                        <i class="bi bi-list-ul"></i>
                    </button>
                </div>

                <!-- Create Button -->
                <a href="{{ route('contacts.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="bi bi-plus-circle mr-2"></i>
                    Yeni Kişi
                </a>
            </div>
        </div>

        <!-- List View -->
        @if($viewMode === 'list')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('first_name')">
                                <div class="flex items-center space-x-1">
                                    <span>İsim</span>
                                    @if($sortField === 'first_name')
                                        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İletişim
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Şirket
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sorumlu
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($contact->first_name, 0, 1)) }}{{ strtoupper(substr($contact->last_name ?? '', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $contact->first_name }} {{ $contact->last_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $contact->title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <i class="bi bi-envelope text-gray-400 mr-2"></i>{{ $contact->email }}
                                    </div>
                                    @if($contact->phone)
                                        <div class="text-sm text-gray-500">
                                            <i class="bi bi-telephone text-gray-400 mr-2"></i>{{ $contact->phone }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($contact->account)
                                        <div class="text-sm text-gray-900">{{ $contact->account->name }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $contact->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $contact->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $contact->status === 'potential' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $contact->owner->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('contacts.show', $contact) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('contacts.edit', $contact) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button wire:click="deleteContact({{ $contact->id }})" wire:confirm="Bu kişiyi silmek istediğinizden emin misiniz?" class="text-red-600 hover:text-red-900">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl mb-2"></i>
                                    <p>Henüz kişi bulunmuyor.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Grid View -->
        @if($viewMode === 'grid')
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($contacts as $contact)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                            <div class="flex flex-col items-center text-center">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl mb-3">
                                    {{ strtoupper(substr($contact->first_name, 0, 1)) }}{{ strtoupper(substr($contact->last_name ?? '', 0, 1)) }}
                                </div>

                                <h3 class="font-semibold text-gray-900 mb-1">
                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                </h3>

                                @if($contact->title)
                                    <p class="text-sm text-gray-600 mb-2">{{ $contact->title }}</p>
                                @endif

                                @if($contact->account)
                                    <p class="text-xs text-gray-500 mb-3">
                                        <i class="bi bi-building mr-1"></i>{{ $contact->account->name }}
                                    </p>
                                @endif

                                <div class="w-full space-y-1 mb-3">
                                    <div class="text-xs text-gray-600 truncate">
                                        <i class="bi bi-envelope mr-1"></i>{{ $contact->email }}
                                    </div>
                                    @if($contact->phone)
                                        <div class="text-xs text-gray-600">
                                            <i class="bi bi-telephone mr-1"></i>{{ $contact->phone }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-center space-x-2 w-full pt-3 border-t">
                                    <a href="{{ route('contacts.show', $contact) }}" class="flex-1 text-center px-3 py-1 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded transition">
                                        <i class="bi bi-eye"></i> Görüntüle
                                    </a>
                                    <a href="{{ route('contacts.edit', $contact) }}" class="flex-1 text-center px-3 py-1 text-xs font-medium text-gray-600 hover:bg-gray-50 rounded transition">
                                        <i class="bi bi-pencil"></i> Düzenle
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-2"></i>
                            <p>Henüz kişi bulunmuyor.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
