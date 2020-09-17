<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <div class="card-body py-5 px-4">
            <form method="POST" action="/reset-password">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="row mb-3">
                    <x-jet-label value="Email" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    </div>
                </div>

                <div class="row mb-3">
                    <x-jet-label value="Password" class="col-md-4 col-form-label text-md-right" />

                    <div class="col-md-6">
                        <x-jet-input class="form-control" type="password" name="password" required autocomplete="new-password" />
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
                            {{ __('Reset Password') }}
                        </x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
