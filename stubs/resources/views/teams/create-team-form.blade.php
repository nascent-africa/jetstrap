<x-jet-form-section submit="createTeam">
    <x-slot name="title">
        Team Details
    </x-slot>

    <x-slot name="description">
        Create a new team to collaborate with others on projects.
    </x-slot>

    <x-slot name="form">
        <div class="mb-4">
            <x-jet-label value="Team Owner" class="font-weight-bold" />

            <div class="d-flex mt-2">
                <img class="rounded-circle" width="48" src="{{ $this->user->profile_photo_url }}">

                <div class="ml-2">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-muted">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Team Name" />
            <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                         wire:model.defer="state.name" autofocus />
            <x-jet-input-error for="name" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            Create
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
