<x-guest-layout class="register-page">
    <div class="register-box">
        <div class="register-logo">
            <x-jet-authentication-card-logo />
        </div>

        <x-jet-authentication-card>
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"
                               placeholder="{{ __('Name') }}" required autofocus autocomplete="name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <x-jet-input-error for="name"></x-jet-input-error>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}">
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
                        <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required autocomplete="new-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <x-jet-button class="btn-block">
                                {{ __('Register') }}
                            </x-jet-button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{--<div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div>--}}

                <a href="{{ route('login') }}" class="text-center">{{ __('Already registered?') }}</a>
            </div>
            <!-- /.form-box -->
        </x-jet-authentication-card>
    </div>
    <!-- /.register-box -->
</x-guest-layout>
