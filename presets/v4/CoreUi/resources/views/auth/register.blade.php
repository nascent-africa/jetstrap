<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <x-jet-authentication-card>

                    <x-jet-validation-errors class="mb-4" />

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h1>{{ __('Register') }}</h1>
                            <p class="text-muted">Create your account</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                          <span class="input-group-text">
                            <svg class="c-icon">
                              <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                            </svg>
                          </span>
                                </div>
                                <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                                             :value="old('name')" required autofocus autocomplete="name" placeholder="{{ __('Name') }}" />
                                <x-jet-input-error for="name"></x-jet-input-error>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                          <span class="input-group-text">
                            <svg class="c-icon">
                              <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-envelope-open"></use>
                            </svg>
                          </span>
                                </div>
                                <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                                             :value="old('email')" required placeholder="{{ __('E-Mail Address') }}" />
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
                                <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                                             name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}" />
                                <x-jet-input-error for="password"></x-jet-input-error>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                          <span class="input-group-text">
                            <svg class="c-icon">
                              <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                            </svg>
                          </span>
                                </div>

                                <x-jet-input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}" />
                            </div>
                            <button class="btn btn-block btn-success" type="submit">{{ __('Register') }}</button>
                        </form>
                    </div>
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-guest-layout>
