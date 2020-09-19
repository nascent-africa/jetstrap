<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="card-body py-5 px-4">
            <div class="mb-4 small text-muted">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <x-jet-validation-errors class="mb-4 rounded-0" />

            <form method="POST" action="/forgot-password">
                @csrf

                <div  class="mb-3">
                    <x-jet-label value="Email" />
                    <x-jet-input type="email" name="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                 :value="old('email')" required autofocus />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <x-jet-button>
                        {{ __('Email Password Reset Link') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
