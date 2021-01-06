<x-guest-layout class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <x-jet-authentication-card-logo />
        </div>

        <x-jet-authentication-card>
            <div class="card-body login-card-body">
                <form method="POST" action="/reset-password">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="{{ __('Email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <x-jet-input-error for="email"></x-jet-input-error>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <x-jet-input-error for="password"></x-jet-input-error>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required autocomplete="new-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <x-jet-input-error for="password_confirmation"></x-jet-input-error>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <x-jet-button class="btn-block">
                                {{ __('Reset Password') }}
                            </x-jet-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
