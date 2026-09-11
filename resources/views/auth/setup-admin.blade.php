<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Admin - Kopi Kita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 text-gray-800 antialiased font-sans flex items-center justify-center min-h-screen">

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg border-t-4 border-blue-500">
        
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-blue-600">Setup Admin</h1>
            <p class="text-gray-500 mt-1">Create the first admin user</p>
        </div>

        <form method="POST" action="{{ route('setup-admin.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                <input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                <input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                <input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
            </div>

            <!-- Setup Key -->
            <div class="mt-4">
                <label for="setup_key" class="block font-medium text-sm text-gray-700">{{ __('Setup Key') }}</label>
                <input id="setup_key" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2 border" type="text" name="setup_key" required />
                <p class="text-xs text-gray-500 mt-1">Enter the 32-character setup key configured in the system.</p>
                <x-input-error :messages="$errors->get('setup_key')" class="mt-2 text-red-600" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full justify-center">
                    {{ __('Create Admin Account') }}
                </button>
            </div>
        </form>
    </div>

</body>
</html>
