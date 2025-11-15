<div>
    <form wire:submit="save" class="space-y-8">
        {{-- Basic Information --}}
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                    Temel Bilgiler
                </h3>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                    {{-- Salutation --}}
                    <div class="sm:col-span-1">
                        <label for="salutation" class="block text-sm font-medium text-gray-700">
                            Ünvan
                        </label>
                        <select 
                            id="salutation"
                            wire:model="salutation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                            <option value="">Seçiniz</option>
                            <option value="Mr">Bay</option>
                            <option value="Mrs">Bayan</option>
                            <option value="Ms">Bn.</option>
                            <option value="Dr">Dr.</option>
                            <option value="Prof">Prof.</option>
                        </select>
                        @error('salutation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- First Name --}}
                    <div class="sm:col-span-2">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            İsim <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="first_name"
                            wire:model="first_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            required
                        >
                        @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="sm:col-span-3">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Soyisim <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="last_name"
                            wire:model="last_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            required
                        >
                        @error('last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            E-posta <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            wire:model="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            required
                        >
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="sm:col-span-3">
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Telefon
                        </label>
                        <input 
                            type="tel" 
                            id="phone"
                            wire:model="phone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Account --}}
                    <div class="sm:col-span-3">
                        <label for="account_id" class="block text-sm font-medium text-gray-700">
                            Şirket
                        </label>
                        <select 
                            id="account_id"
                            wire:model="account_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                            <option value="">Seçiniz</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Owner --}}
                    <div class="sm:col-span-3">
                        <label for="owner_id" class="block text-sm font-medium text-gray-700">
                            Sahip
                        </label>
                        <select 
                            id="owner_id"
                            wire:model="owner_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('owner_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Title --}}
                    <div class="sm:col-span-3">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            İş Ünvanı
                        </label>
                        <input 
                            type="text" 
                            id="title"
                            wire:model="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Durum
                        </label>
                        <select 
                            id="status"
                            wire:model="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                            <option value="active">Aktif</option>
                            <option value="inactive">Pasif</option>
                            <option value="disqualified">Niteliksiz</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Advanced Information (Collapsible) --}}
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <button 
                    type="button"
                    wire:click="toggleAdvanced"
                    class="flex items-center justify-between w-full text-left"
                >
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Detaylı Bilgiler
                    </h3>
                    <svg 
                        class="h-5 w-5 text-gray-400 transition-transform {{ $showAdvanced ? 'rotate-180' : '' }}" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                @if($showAdvanced)
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-6">
                        {{-- Mobile --}}
                        <div class="sm:col-span-2">
                            <label for="mobile" class="block text-sm font-medium text-gray-700">
                                Mobil Telefon
                            </label>
                            <input 
                                type="tel" 
                                id="mobile"
                                wire:model="mobile"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- WhatsApp --}}
                        <div class="sm:col-span-2">
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700">
                                WhatsApp
                            </label>
                            <input 
                                type="tel" 
                                id="whatsapp"
                                wire:model="whatsapp"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- Secondary Email --}}
                        <div class="sm:col-span-2">
                            <label for="secondary_email" class="block text-sm font-medium text-gray-700">
                                İkinci E-posta
                            </label>
                            <input 
                                type="email" 
                                id="secondary_email"
                                wire:model="secondary_email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- Department --}}
                        <div class="sm:col-span-3">
                            <label for="department" class="block text-sm font-medium text-gray-700">
                                Departman
                            </label>
                            <input 
                                type="text" 
                                id="department"
                                wire:model="department"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- Birthdate --}}
                        <div class="sm:col-span-3">
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">
                                Doğum Tarihi
                            </label>
                            <input 
                                type="date" 
                                id="birthdate"
                                wire:model="birthdate"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- LinkedIn --}}
                        <div class="sm:col-span-3">
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-700">
                                LinkedIn Profili
                            </label>
                            <input 
                                type="url" 
                                id="linkedin_url"
                                wire:model="linkedin_url"
                                placeholder="https://linkedin.com/in/..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- Lead Source --}}
                        <div class="sm:col-span-3">
                            <label for="lead_source" class="block text-sm font-medium text-gray-700">
                                Kaynak
                            </label>
                            <select 
                                id="lead_source"
                                wire:model="lead_source"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                                <option value="">Seçiniz</option>
                                <option value="web_form">Web Formu</option>
                                <option value="google_ads">Google Ads</option>
                                <option value="facebook_ads">Facebook Ads</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="referral">Referans</option>
                                <option value="cold_call">Soğuk Arama</option>
                                <option value="trade_show">Fuar</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>

                        {{-- Address --}}
                        <div class="sm:col-span-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Adres Bilgileri</h4>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="mailing_street" class="block text-sm font-medium text-gray-700">
                                Sokak/Cadde
                            </label>
                            <input 
                                type="text" 
                                id="mailing_street"
                                wire:model="mailing_street"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="mailing_city" class="block text-sm font-medium text-gray-700">
                                Şehir
                            </label>
                            <input 
                                type="text" 
                                id="mailing_city"
                                wire:model="mailing_city"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="mailing_state" class="block text-sm font-medium text-gray-700">
                                İlçe
                            </label>
                            <input 
                                type="text" 
                                id="mailing_state"
                                wire:model="mailing_state"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="mailing_postal_code" class="block text-sm font-medium text-gray-700">
                                Posta Kodu
                            </label>
                            <input 
                                type="text" 
                                id="mailing_postal_code"
                                wire:model="mailing_postal_code"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            >
                        </div>

                        {{-- Description --}}
                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Notlar
                            </label>
                            <textarea 
                                id="description"
                                wire:model="description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            ></textarea>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex justify-end space-x-3">
            <a 
                href="{{ $isEditMode ? route('contacts.show', $contact) : route('contacts.index') }}"
                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
                İptal
            </a>
            <button 
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
                {{ $isEditMode ? 'Güncelle' : 'Kaydet' }}
            </button>
        </div>
    </form>
</div>