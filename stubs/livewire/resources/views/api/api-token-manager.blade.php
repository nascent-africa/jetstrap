<div>
    <!-- Generate API Token -->
    <x-jet-form-section submit="createApiToken">
        <x-slot name="title">
            Create API Token
        </x-slot>

        <x-slot name="description">
            API tokens allow third-party services to authenticate with our application on your behalf.
        </x-slot>

        <x-slot name="form">
            <div class="w-75">
                <!-- Token Name -->
                <div class="mb-3">
                    <x-jet-label for="name" value="Token Name" />
                    <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                 wire:model.defer="createApiTokenForm.name" autofocus />
                    <x-jet-input-error for="name" />
                </div>

                <!-- Token Permissions -->
                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                    <div>
                        <x-jet-label for="permissions" value="Permissions" />

                        <div class="mt-2 grid row">
                            @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="check-permissions-{{ $permission }}" class="form-check-input" type="checkbox" value="{{ $permission }}"
                                               wire:model.defer="createApiTokenForm.permissions">
                                        <label class="form-check-label" for="check-permissions-{{ $permission }}">
                                            {{ $permission }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="created">
                {{ __('Created.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Create') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <x-jet-section-border />

        <!-- Manage API Tokens -->
        <div class="mt-5 mt-sm-0">
            <x-jet-action-section>
                <x-slot name="title">
                    Manage API Tokens
                </x-slot>

                <x-slot name="description">
                    You may delete any of your existing tokens if they are no longer needed.
                </x-slot>

                <!-- API Token List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $token->name }}
                                </div>

                                <div class="d-flex">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-muted">
                                            Last used {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <button class="btn btn-link text-secondary"
                                                wire:loading.attr="disabled"
                                                wire:target="updateApiToken"
                                                wire:click="$emit('manageApiTokenPermissions', {{ $token->id }})">
                                            Permissions
                                        </button>
                                    @endif

                                    <button class="btn btn-link text-danger text-decoration-none"
                                            wire:loading.attr="disabled"
                                            wire:target="deleteApiToken"
                                            wire:click="$emit('confirmApiTokenDeletion', {{ $token->id }})">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
@endif

<!-- Token Value Modal -->
    <x-jet-dialog-modal id="displayingToken">
        <x-slot name="title">
            API Token
        </x-slot>

        <x-slot name="content">
            <div>
                Please copy your new API token. For your security, it won't be shown again.
            </div>

            <div class="bg-light rounded p-3 user-select-all">
                {{ $plainTextToken }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('displayingToken', false)"
                                    wire:loading.attr="disabled"
                                    data-dismiss="modal">
                Close
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- API Token Permissions Modal -->
    <x-jet-dialog-modal id="managingApiTokenPermissionsModal">
        <x-slot name="title">
            API Token Permissions
        </x-slot>

        <x-slot name="content">
            <div class="mt-2 row">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $permission }}"
                                   wire:model.defer="updateApiTokenForm.permissions">
                            <label class="form-check-label">
                                {{ $permission }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingApiTokenPermissions', false)"
                                    wire:loading.attr="disabled" data-dismiss="modal">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            {{--
                This `wire:loading.remove` is added for `manageApiTokenPermissions` to take full effect before a save
                can be made to avoid accidental updates.
            --}}
            <div wire:loading.remove
                 wire:target="manageApiTokenPermissions">
                <x-jet-button wire:click="updateApiToken"
                              wire:loading.attr="disabled"
                              data-dismiss="modal">
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <x-jet-confirmation-modal id="confirmApiTokenDeletionModal">
        <x-slot name="title">
            Delete API Token
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to delete this API token?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled" data-dismiss="modal">
                Nevermind
            </x-jet-secondary-button>


            <div wire:loading.remove
                 wire:target="confirmApiTokenDeletion">
                <x-jet-danger-button wire:loading.attr="disabled"
                                     wire:click="deleteApiToken"
                                     data-dismiss="modal">
                    Delete
                </x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
</div>

@push('scripts')
    <script>
        Livewire.on('manageApiTokenPermissions', id => {
            @this.manageApiTokenPermissions(id)
            new Bootstrap.Modal(document.getElementById('managingApiTokenPermissionsModal')).toggle()
        })

        Livewire.on('confirmApiTokenDeletion', id => {
            @this.confirmApiTokenDeletion(id)
            new Bootstrap.Modal(document.getElementById('confirmApiTokenDeletionModal')).toggle()
        })

        Livewire.on('created', id => {
            new Bootstrap.Modal(document.getElementById('displayingToken')).toggle()
        })
    </script>
@endpush
