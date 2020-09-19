<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        {{--<div class="card-header">{{ __('Register') }}</div>--}}

        <x-jet-validation-errors class="mb-4" />

        <div class="card-body py-5 px-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <x-jet-label value="Name" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                                     :value="old('name')" required autofocus autocomplete="name" />
                        <x-jet-input-error for="name"></x-jet-input-error>
                    </div>
                </div>

                <div class="row mb-3">
                    <x-jet-label value="Email" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                                     :value="old('email')" required />
                        <x-jet-input-error for="email"></x-jet-input-error>
                    </div>
                </div>

                <div class="row mb-3">
                    <x-jet-label value="Password" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                                     name="password" required autocomplete="new-password" />
                        <x-jet-input-error for="password"></x-jet-input-error>
                    </div>
                </div>

                <div class="row mb-3">
                    <x-jet-label value="Confirm Password" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <x-jet-button>
                            {{ __('Register') }}
                        </x-jet-button>

                        <a class="small text-muted ml-4 text-decoration-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
