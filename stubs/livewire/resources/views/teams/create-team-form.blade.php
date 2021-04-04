<x-jet-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new team to collaborate with others on projects.') }}
    </x-slot>

    <x-slot name="form">
        <div class="mb-3">
            <x-jet-label value="{{ __('Team Owner') }}" />

            <div class="d-flex mt-2">
                <img class="rounded-circle" width="48" src="{{ $this->user->profile_photo_url }}">

                <div class="ml-2">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-muted">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="w-md-75">
            <div class="form-group">
                <x-jet-label for="name" value="{{ __('Team Name') }}" />
                <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                             wire:model.defer="state.name" autofocus />
                <x-jet-input-error for="name" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>