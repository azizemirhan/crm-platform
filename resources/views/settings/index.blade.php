<x-app-layout>
    @push('styles')
    <style>
        /* Settings Page Custom Styles */
        .settings-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .settings-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .settings-card:hover .settings-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .settings-icon {
            transition: all 0.3s ease;
        }

        .settings-header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .settings-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .category-fade-in {
            animation: fadeInUp 0.6s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="px-4">
            <h2 class="text-2xl font-bold text-gray-900">Settings</h2>
            <p class="text-sm text-gray-600 mt-1">Manage your CRM platform configuration and preferences</p>
        </div>
    </x-slot>

    <div class="space-y-8 category-fade-in">
        <!-- Personal Settings -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <div class="h-1 w-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></div>
                Personal Settings
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Profile -->
                <a href="{{ route('profile.edit') }}" class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-blue-300">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Profile</h4>
                            <p class="text-sm text-gray-600">Update your personal information and photo</p>
                        </div>
                    </div>
                </a>

                <!-- Notifications -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-yellow-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Notifications</h4>
                            <p class="text-sm text-gray-600">Configure email and push notifications</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-red-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Security</h4>
                            <p class="text-sm text-gray-600">Password and two-factor authentication</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization Settings -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <div class="h-1 w-8 bg-gradient-to-r from-green-600 to-teal-600 rounded-full"></div>
                Organization Settings
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Company Info -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-green-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Company Information</h4>
                            <p class="text-sm text-gray-600">Business details and contact info</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Users & Teams -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-indigo-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Users & Teams</h4>
                            <p class="text-sm text-gray-600">Manage team members and permissions</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Roles & Permissions -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-purple-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Roles & Permissions</h4>
                            <p class="text-sm text-gray-600">Define access levels and permissions</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration & Automation -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <div class="h-1 w-8 bg-gradient-to-r from-orange-600 to-pink-600 rounded-full"></div>
                Integration & Automation
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Integrations -->
                <a href="{{ route('settings.integrations') }}" class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-orange-300">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Integrations</h4>
                            <p class="text-sm text-gray-600">Connect third-party apps and services</p>
                            <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded settings-badge">Active</span>
                        </div>
                    </div>
                </a>

                <!-- Email Configuration -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-pink-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-pink-100 rounded-lg">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Email Configuration</h4>
                            <p class="text-sm text-gray-600">SMTP settings and email templates</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- API Keys -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-blue-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">API Keys</h4>
                            <p class="text-sm text-gray-600">Manage API access and webhooks</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Workflows -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-teal-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-teal-100 rounded-lg">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Workflows & Automation</h4>
                            <p class="text-sm text-gray-600">Create automated business processes</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customization -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <div class="h-1 w-8 bg-gradient-to-r from-cyan-600 to-blue-600 rounded-full"></div>
                Customization
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Custom Fields -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-cyan-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-cyan-100 rounded-lg">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Custom Fields</h4>
                            <p class="text-sm text-gray-600">Add custom fields to your data</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Tags & Categories -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-purple-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Tags & Categories</h4>
                            <p class="text-sm text-gray-600">Organize data with tags and categories</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Theme & Branding -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-pink-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-pink-100 rounded-lg">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Theme & Branding</h4>
                            <p class="text-sm text-gray-600">Customize colors, logo, and appearance</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data & System -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <div class="h-1 w-8 bg-gradient-to-r from-gray-600 to-slate-600 rounded-full"></div>
                Data & System
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Backup & Export -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-gray-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Backup & Export</h4>
                            <p class="text-sm text-gray-600">Backup data and export to various formats</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Audit Logs -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-slate-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-slate-100 rounded-lg">
                            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Audit Logs</h4>
                            <p class="text-sm text-gray-600">Track all system activities and changes</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>

                <!-- Data Import -->
                <div class="settings-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-indigo-300 opacity-75">
                    <div class="flex items-start gap-4">
                        <div class="settings-icon p-3 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Data Import</h4>
                            <p class="text-sm text-gray-600">Import data from CSV, Excel, and more</p>
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Settings Page Custom JavaScript
        (function() {
            'use strict';

            document.addEventListener('DOMContentLoaded', function() {
                // Add click event to all settings cards
                const settingsCards = document.querySelectorAll('.settings-card');
                settingsCards.forEach(card => {
                    card.addEventListener('click', function(e) {
                        // Only prevent default if it's a disabled card (opacity-75)
                        if (this.classList.contains('opacity-75')) {
                            e.preventDefault();
                            // Show coming soon message
                            const comingSoonBadge = this.querySelector('.inline-block');
                            if (comingSoonBadge && comingSoonBadge.textContent.includes('Coming Soon')) {
                                comingSoonBadge.classList.add('settings-badge');
                                setTimeout(() => {
                                    comingSoonBadge.classList.remove('settings-badge');
                                }, 2000);
                            }
                        }
                    });
                });

                // Add smooth scroll for categories
                const categories = document.querySelectorAll('.category-fade-in > div');
                categories.forEach((category, index) => {
                    category.style.animationDelay = `${index * 0.1}s`;
                });

                console.log('Settings page initialized successfully');
            });
        })();
    </script>
    @endpush
</x-app-layout>
