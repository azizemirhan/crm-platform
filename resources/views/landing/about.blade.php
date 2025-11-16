<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - {{ config('app.name') }}</title>
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
                    <a href="{{ route('features') }}" class="text-gray-700 hover:text-indigo-600">Features</a>
                    <a href="{{ route('tenant.register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Start Free Trial</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-bold text-gray-900 mb-8 text-center">About Us</h1>
            <div class="prose prose-lg mx-auto">
                <p class="text-xl text-gray-600 mb-6">
                    {{ config('app.name') }} is a modern multi-tenant CRM platform designed for businesses of all sizes.
                </p>
                <p class="text-gray-600">
                    Built with Laravel and PostgreSQL, our platform provides enterprise-level security with schema-based tenant isolation, ensuring your data is always protected and separate from other tenants.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
