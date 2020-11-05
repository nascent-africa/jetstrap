<x-guest-layout class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <x-jet-authentication-card-logo />
        </div>

        <x-jet-authentication-card>
            <div class="card-body login-card-body">
                <div x-data="{ recovery: false }">
                    <p class="login-box-msg" x-show="! recovery">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </p>

                    <p class="login-box-msg" x-show="recovery">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </p>

                    <form method="POST" action="/two-factor-challenge">
                        @csrf

                        <div class="mt-4" x-show="! recovery">
                            <x-jet-label value="{{ __('Code') }}" />
                            <x-jet-input class="{{ $errors->has('code') ? 'is-invalid' : '' }}" type="text"
                                         inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                            <x-jet-input-error for="code"></x-jet-input-error>
                        </div>

                        <div class="mt-4" x-show="recovery">
                            <x-jet-label value="{{ __('Recovery Code') }}" />
                            <x-jet-input class="{{ $errors->has('recovery_code') ? 'is-invalid' : '' }}" type="text"
                                         name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                            <x-jet-input-error for="recovery_code"></x-jet-input-error>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-outline-secondary"
                                    x-show="! recovery"
                                    x-on:click="
                                            recovery = true;
                                            $nextTick(() => { $refs.recovery_code.focus() })
                                        ">
                                {{ __('Use a recovery code') }}
                            </button>

                            <button type="button" class="btn btn-outline-secondary"
                                    x-show="recovery"
                                    x-on:click="
                                            recovery = false;
                                            $nextTick(() => { $refs.code.focus() })
                                        ">
                                {{ __('Use an authentication code') }}
                            </button>

                            <div class="row">
                                <div class="col-12">
                                    <x-jet-button class="btn-block">
                                        {{ __('Login') }}
                                    </x-jet-button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
