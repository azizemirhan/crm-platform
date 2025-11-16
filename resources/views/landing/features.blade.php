<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">{{ config('app.name') }}</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-indigo-600">Pricing</a>
                    <a href="{{ route('features') }}" class="text-indigo-600 font-semibold">Features</a>
                    <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Start Free Trial</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Powerful Features</h1>
                <p class="text-xl text-gray-600">Everything you need to manage customer relationships</p>
            </div>

            <div class="space-y-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-4">Contact & Lead Management</h2>
                        <p class="text-gray-600 mb-6">Centralize all your customer data. Track interactions, manage leads, and never miss a follow-up.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>360° contact view</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Lead scoring & qualification</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Custom fields & tags</li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-100 to-purple-100 p-8 rounded-xl h-64"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 p-8 rounded-xl h-64 order-2 md:order-1"></div>
                    <div class="order-1 md:order-2">
                        <h2 class="text-3xl font-bold mb-4">Sales Pipeline</h2>
                        <p class="text-gray-600 mb-6">Visualize your sales process with Kanban boards. Move deals through stages and close more sales.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Drag & drop Kanban boards</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Win/Loss tracking</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Revenue forecasting</li>
                        </ul>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-4">Multi-Tenant Architecture</h2>
                        <p class="text-gray-600 mb-6">Each tenant gets their own isolated database schema. Your data is completely secure and separate.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>PostgreSQL schema-based isolation</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Subdomain routing</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Custom branding per tenant</li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-green-100 to-blue-100 p-8 rounded-xl h-64"></div>
                </div>
            </div>

            <div class="mt-20 text-center">
                <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition inline-block">
                    Start Your Free Trial
                </a>
            </div>
        </div>
    </div>
</body>
</html>
