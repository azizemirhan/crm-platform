<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - {{ config('app.name') }}</title>
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
                    <a href="{{ route('pricing') }}" class="text-indigo-600 font-semibold">Pricing</a>
                    <a href="{{ route('features') }}" class="text-gray-700 hover:text-indigo-600">Features</a>
                    <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Start Free Trial</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h1>
                <p class="text-xl text-gray-600">Choose the plan that's right for your business</p>
                <p class="text-gray-500 mt-2">All plans include 14-day free trial. No credit card required.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 max-w-7xl mx-auto">
                <!-- Plans same as home page -->
            </div>
        </div>
    </div>
</body>
</html>
