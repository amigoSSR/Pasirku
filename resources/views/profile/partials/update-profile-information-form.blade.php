<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="Username" :value="__('Username')" />
            <x-text-input id="Username" name="Username" type="text" class="mt-1 block w-full" :value="old('Username', $user->Username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('Username')" />
        </div>

        <div>
            <x-input-label for="Nomer_Telepon" :value="__('Nomer Telepon')" />
            <x-text-input id="Nomer_Telepon" name="Nomer_Telepon" type="number" class="mt-1 block w-full" :value="old('Nomer_Telepon', $user->Nomer_Telepon)" required />
            <x-input-error class="mt-2" :messages="$errors->get('Nomer_Telepon')" />
        </div>

        <div>
            <x-input-label for="Email" :value="__('Email')" />
            <x-text-input id="Email" name="Email" type="email" class="mt-1 block w-full" :value="old('Email', $user->Email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('Email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
