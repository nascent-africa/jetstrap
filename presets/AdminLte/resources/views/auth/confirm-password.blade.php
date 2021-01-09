<x-guest-layout class="login-page">
    <div class="login-box">
        <div class="mb-4 text-sm text-muted">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <div class="login-logo">
            <x-jet-authentication-card-logo />
        </div>

        <x-jet-authentication-card>
            <div class="card-body login-card-body">

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div>
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" autofocus />
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <x-jet-button class="ml-4">
                            {{ __('Confirm') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
