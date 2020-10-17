<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('status'))
                    <div class="alert alert-success mb-3 rounded-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <svg class="c-icon">
                                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                        </svg>
                                      </span>
                                    </div>

                                    <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                                 name="email" :value="old('email')" required />
                                    <x-jet-input-error for="email"></x-jet-input-error>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <svg class="c-icon">
                                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                                        </svg>
                                      </span>
                                    </div>

                                    <x-jet-input class="{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                                                 name="password" required autocomplete="current-password" />
                                    <x-jet-input-error for="password"></x-jet-input-error>
                                </div>

                                <div class="input-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <x-jet-button class="px-4">
                                            {{ __('Login') }}
                                        </x-jet-button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('password.request') }}" class="btn btn-link px-0">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2>Sign up</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('register') }}" class="btn btn-primary active mt-3">{{ __('Register') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
