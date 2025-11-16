<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-white">
                    🔐 Super Admin Login
                </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Platform administrator access only
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-900 bg-opacity-50 border border-red-500 rounded-lg p-4">
                    <ul class="list-disc list-inside text-sm text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-900 bg-opacity-50 border border-green-500 rounded-lg p-4">
                    <p class="text-sm text-green-200">{{ session('status') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('super-admin.login.store') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-700 bg-gray-800 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="admin@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input id="password" name="password" type="password" required
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-700 bg-gray-800 placeholder-gray-500 text-white rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-700 rounded bg-gray-800">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">
                        Remember me
                    </label>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in as Super Admin
                    </button>
                </div>

                <div class="text-center text-sm">
                    <a href="{{ route('home') }}" class="font-medium text-gray-400 hover:text-gray-300">
                        ← Back to home
                    </a>
                </div>
            </form>

            <div class="mt-8 text-center text-xs text-gray-500">
                <p>Default credentials for development:</p>
                <p class="mt-1 font-mono bg-gray-800 p-2 rounded">
                    admin@test.com / password
                </p>
            </div>
        </div>
    </div>
</body>
</html>
