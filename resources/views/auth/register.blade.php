<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="Username" :value="__('Username')" />
            <x-text-input id="Username" class="block mt-1 w-full" type="text" name="Username" :value="old('Username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('Username')" class="mt-2" />
        </div>

        <!-- Nomer Telepon -->
        <div class="mt-4">
            <x-input-label for="Nomer_Telepon" :value="__('Nomer Telepon')" />
            <x-text-input id="Nomer_Telepon" class="block mt-1 w-full" type="text" name="Nomer_Telepon" :value="old('Nomer_Telepon')"  />
            <x-input-error :messages="$errors->get('Nomer_Telepon')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" class="block mt-1 w-full" type="email" name="Email" :value="old('Email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('Email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="Password" :value="__('Password')" />

            <x-text-input id="Password" class="block mt-1 w-full"
                            type="password"
                            name="Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('Password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="Password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="Password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="Password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('Password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
