<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - {{ config('app.name') }}</title>
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
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-bold text-gray-900 mb-8 text-center">Contact Us</h1>
            <div class="bg-white p-8 rounded-xl shadow-sm">
                <p class="text-center text-gray-600 mb-8">Have questions? We'd love to hear from you.</p>
                <div class="text-center">
                    <p class="text-gray-900 font-semibold mb-2">Email</p>
                    <a href="mailto:support@yourcrm.com" class="text-indigo-600 hover:underline">support@yourcrm.com</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
