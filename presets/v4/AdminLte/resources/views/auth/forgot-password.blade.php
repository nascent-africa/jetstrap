<x-guest-layout class="login-page">
    <div class="login-box">
        @if (session('status'))
            <div class="alert alert-success mb-3 rounded-0" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="login-logo">
            <x-jet-authentication-card-logo />
        </div>

        <x-jet-authentication-card>
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    {{ __('You forgot your password? Here you can easily retrieve a new password.') }}
                </p>

                <form method="POST" action="/forgot-password">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="{{ __('Email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-jet-button class="btn-block">
                                {{ __('Email Password Reset Link') }}
                            </x-jet-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </p>
                @if (Route::has('register'))
                    <p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center">{{ __('Register a new membership') }}</a>
                    </p>
                @endif
            </div>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
