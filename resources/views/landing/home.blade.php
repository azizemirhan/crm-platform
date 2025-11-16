<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Multi-Tenant CRM Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">{{ config('app.name') }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-indigo-600">Pricing</a>
                    <a href="{{ route('features') }}" class="text-gray-700 hover:text-indigo-600">Features</a>
                    <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Start Free Trial</a>
                    <a href="{{ route('super-admin.login') }}" class="text-gray-700 hover:text-indigo-600">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
                    Powerful Multi-Tenant
                    <span class="text-indigo-600">CRM Platform</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Manage your customer relationships with our secure, scalable, and feature-rich CRM solution.
                    Each tenant gets their own isolated environment.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 transform hover:scale-105 transition">
                        Start Free 14-Day Trial
                    </a>
                    <a href="#features" class="bg-white text-indigo-600 border-2 border-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-50 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Everything You Need</h2>
                <p class="text-xl text-gray-600">Powerful features for modern businesses</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Contact Management</h3>
                    <p class="text-gray-600">Organize and manage all your contacts, leads, and accounts in one place.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sales Pipeline</h3>
                    <p class="text-gray-600">Track opportunities through your sales pipeline with Kanban boards.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Isolated</h3>
                    <p class="text-gray-600">Each tenant has their own isolated database schema for maximum security.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Meeting Scheduler</h3>
                    <p class="text-gray-600">Built-in calendar with FullCalendar integration for meeting management.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Task Management</h3>
                    <p class="text-gray-600">Organize tasks with Kanban boards and track team productivity.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Analytics & Reports</h3>
                    <p class="text-gray-600">Get insights with built-in analytics and customizable reports.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-gray-600">Choose the plan that's right for your business</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Trial Plan -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition">
                    <h3 class="text-2xl font-bold mb-2">Trial</h3>
                    <div class="text-4xl font-bold text-indigo-600 mb-4">Free</div>
                    <p class="text-gray-600 mb-6">14 days</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            3 users
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            100 contacts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            500 MB storage
                        </li>
                    </ul>
                    <a href="{{ route('tenant.register') }}" class="block w-full bg-gray-200 text-gray-800 text-center py-2 rounded-lg hover:bg-gray-300 transition">Start Trial</a>
                </div>

                <!-- Starter Plan -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition">
                    <h3 class="text-2xl font-bold mb-2">Starter</h3>
                    <div class="text-4xl font-bold text-indigo-600 mb-4">$29</div>
                    <p class="text-gray-600 mb-6">per month</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            5 users
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            1,000 contacts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            2 GB storage
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Email integration
                        </li>
                    </ul>
                    <a href="{{ route('tenant.register') }}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded-lg hover:bg-indigo-700 transition">Get Started</a>
                </div>

                <!-- Professional Plan -->
                <div class="bg-indigo-600 text-white p-8 rounded-xl shadow-lg transform scale-105">
                    <div class="bg-yellow-400 text-indigo-900 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">POPULAR</div>
                    <h3 class="text-2xl font-bold mb-2">Professional</h3>
                    <div class="text-4xl font-bold mb-4">$79</div>
                    <p class="text-indigo-100 mb-6">per month</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            25 users
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            10,000 contacts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            10 GB storage
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Advanced reports
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            API access
                        </li>
                    </ul>
                    <a href="{{ route('tenant.register') }}" class="block w-full bg-white text-indigo-600 text-center py-2 rounded-lg hover:bg-gray-100 transition font-semibold">Get Started</a>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition">
                    <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                    <div class="text-4xl font-bold text-indigo-600 mb-4">$199</div>
                    <p class="text-gray-600 mb-6">per month</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            100 users
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            50,000 contacts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            50 GB storage
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            White label
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Dedicated support
                        </li>
                    </ul>
                    <a href="{{ route('tenant.register') }}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded-lg hover:bg-indigo-700 transition">Contact Sales</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-600 py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to get started?</h2>
            <p class="text-xl text-indigo-100 mb-8">Join thousands of businesses using our platform</p>
            <a href="{{ route('tenant.register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition inline-block">
                Start Your Free Trial
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-bold mb-4">{{ config('app.name') }}</h3>
                    <p class="text-sm">Multi-tenant CRM platform for modern businesses.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('features') }}" class="hover:text-white">Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-white">About</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Admin</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('super-admin.login') }}" class="hover:text-white">Super Admin Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
