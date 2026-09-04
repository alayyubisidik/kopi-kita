<x-guest-layout>
    <form method="POST" action="{{ route('setup-admin.store') }}">
        @csrf

        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Setup Admin - Kopi Kita</h2>
            <p class="text-gray-600 mb-8">This is the first-time setup. Create the first admin user for the system.</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Setup Key -->
        <div class="mt-4">
            <x-input-label for="setup_key" :value="__('Setup Key')" />
            <x-text-input id="setup_key" class="block mt-1 w-full" type="text" name="setup_key" required />
            <x-input-error :messages="$errors->get('setup_key')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Enter the 32-character setup key configured in the system.</p>
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="ms-4">
                {{ __('Create Admin Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>