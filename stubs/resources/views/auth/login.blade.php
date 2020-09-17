<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        {{--<div class="card-header">{{ __('Login') }}</div>--}}

        <x-jet-validation-errors class="mb-4" />

        <div class="card-body py-5 px-4">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row mb-3">
                <x-jet-label value="Email" class="col-md-4 col-form-label text-md-right" />

                <div class="col-md-6">
                    <x-jet-input class="form-control" type="email" name="email" :value="old('email')" required />
                </div>
            </div>

            <div class="row mb-3">
                <x-jet-label value="Password" class="col-md-4 col-form-label text-md-right" />

                <div class="col-md-6">
                    <x-jet-input class="form-control" type="password" name="password" required autocomplete="current-password" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <x-jet-button>
                        {{ __('Login') }}
                    </x-jet-button>

                    @if (Route::has('password.request'))
                        <a class="small text-muted ml-4 text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
