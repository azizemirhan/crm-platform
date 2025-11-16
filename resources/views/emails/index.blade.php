<x-app-layout>
    @push('styles')
    <style>
        /* Emails Page Custom Styles */
        .emails-header-gradient {
            background: linear-gradient(135deg, #9333ea 0%, #db2777 100%);
        }

        .email-folder-tab {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .email-folder-tab:hover {
            transform: translateY(-2px);
        }

        .email-folder-tab.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, #9333ea 0%, #db2777 100%);
            border-radius: 2px;
        }

        .email-list-fade-in {
            animation: emailFadeIn 0.5s ease-in-out;
        }

        @keyframes emailFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .folder-nav-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .folder-nav-container::-webkit-scrollbar {
            height: 6px;
        }

        .folder-nav-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .folder-nav-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .folder-nav-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center px-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Emails</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your email communications and campaigns</p>
            </div>
            <a href="{{ route('emails.compose') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-3 rounded-xl inline-flex items-center gap-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-semibold">Compose Email</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 email-list-fade-in">
        <!-- Email Folder Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="folder-nav-container flex items-center gap-2 overflow-x-auto">
                <a href="{{ route('emails.index', ['folder' => 'inbox']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder', 'inbox') === 'inbox' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-inbox"></i>
                    <span>Inbox</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'sent']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'sent' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-send"></i>
                    <span>Sent</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'drafts']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'drafts' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Drafts</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'starred']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'starred' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-star"></i>
                    <span>Starred</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'archived']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'archived' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-archive"></i>
                    <span>Archived</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'trash']) }}"
                   class="email-folder-tab inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'trash' ? 'active bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-trash"></i>
                    <span>Trash</span>
                </a>
            </div>
        </div>

        <!-- Email List -->
        @livewire('emails.email-list', ['folder' => request()->get('folder', 'inbox')])
    </div>

    @push('scripts')
    <script>
        // Emails Page Custom JavaScript
        (function() {
            'use strict';

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth scroll for folder navigation
                const folderNav = document.querySelector('.folder-nav-container');
                if (folderNav) {
                    const activeTab = folderNav.querySelector('.email-folder-tab.active');
                    if (activeTab) {
                        // Scroll active tab into view
                        activeTab.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });
                    }
                }

                // Add hover effects to folder tabs
                const folderTabs = document.querySelectorAll('.email-folder-tab');
                folderTabs.forEach(tab => {
                    tab.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('active')) {
                            this.style.backgroundColor = '#f3f4f6';
                        }
                    });

                    tab.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('active')) {
                            this.style.backgroundColor = '';
                        }
                    });
                });

                // Log current folder
                const currentFolder = new URLSearchParams(window.location.search).get('folder') || 'inbox';
                console.log('Emails page loaded - Current folder:', currentFolder);
            });

            // Add keyboard navigation for folder tabs
            document.addEventListener('keydown', function(e) {
                const folderTabs = Array.from(document.querySelectorAll('.email-folder-tab'));
                const activeIndex = folderTabs.findIndex(tab => tab.classList.contains('active'));

                if (e.key === 'ArrowLeft' && activeIndex > 0) {
                    e.preventDefault();
                    folderTabs[activeIndex - 1].click();
                } else if (e.key === 'ArrowRight' && activeIndex < folderTabs.length - 1) {
                    e.preventDefault();
                    folderTabs[activeIndex + 1].click();
                }
            });
        })();
    </script>
    @endpush
</x-app-layout>
