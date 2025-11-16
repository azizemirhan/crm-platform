<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Welcome back
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Sign in to your CRM account
                </p>
                @if(tenancy()->initialized)
                    <p class="mt-1 text-center text-xs text-indigo-600 font-semibold">
                        {{ tenant('name') }}
                    </p>
                @endif
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-600">{{ session('status') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-600">{{ session('info') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6 bg-white p-8 rounded-xl shadow-lg" action="{{ route('tenant.login.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('tenant.password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="text-center text-xs text-gray-500 mt-4">
                <p>For demo tenant (acme-corp):</p>
                <p class="font-mono bg-white px-3 py-2 rounded mt-1">
                    john@acme.com / password
                </p>
            </div>
        </div>
    </div>
</body>
</html>
