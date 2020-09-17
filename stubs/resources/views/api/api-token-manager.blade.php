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
            <!-- Token Name -->
            <div>
                <x-jet-label for="name" value="Token Name" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="createApiTokenForm.name" autofocus />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- Token Permissions -->
            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <div>
                    <x-jet-label for="permissions" value="Permissions" />

                    <div class="mt-2 grid row">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <div class="col-6">
                                <div class="form-check">
                                    <input id="check-permissions-{{ $permission }}" class="form-check-input" type="checkbox" value="{{ $permission }}" wire:model.defer="createApiTokenForm.permissions">
                                    <label class="form-check-label" for="check-permissions-{{ $permission }}">
                                        {{ $permission }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="created">
                Created.
            </x-jet-action-message>

            <x-jet-button>
                Create
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
                                        <button class="btn btn-link text-secondary" data-toggle="modal"
                                                wire:click="manageApiTokenPermissions({{ $token->id }})"
                                                data-target="#managingApiTokenPermissions-{{ $token->id }}">
                                            Permissions
                                        </button>
                                    @endif

                                    <button class="btn btn-link text-danger text-decoration-none"
                                            data-toggle="modal"
                                            data-target="#confirmApiTokenDeletion-{{ $token->id }}">
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <!-- API Token Permissions Modal -->
                            <x-jet-dialog-modal id="managingApiTokenPermissions-{{ $token->id }}">
                                <x-slot name="title">
                                    API Token Permissions
                                </x-slot>

                                <x-slot name="content">
                                    <div class="mt-2 row">
                                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $permission }}" wire:model.defer="updateApiTokenForm.permissions">
                                                    <label class="form-check-label">
                                                        {{ $permission }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </x-slot>

                                <x-slot name="footer">
                                    <x-jet-secondary-button data-dismiss="modal">
                                        {{ __('Nevermind') }}
                                    </x-jet-secondary-button>

                                    <x-jet-button class="ml-2" wire:click="updateApiToken"
                                                  wire:click="$emit('updateApiToken', {{ $token->id }})"
                                                  data-dismiss="modal">
                                        {{ __('Save') }}
                                    </x-jet-button>
                                </x-slot>
                            </x-jet-dialog-modal>
                            @push('scripts')
                                <script>
                                    Livewire.on('updateApiToken', id => {
                                        @this.manageApiTokenPermissions(id)
                                        @this.updateApiToken()
                                    })
                                </script>
                            @endpush

                            <!-- Delete Token Confirmation Modal -->
                            <x-jet-confirmation-modal id="confirmApiTokenDeletion-{{ $token->id }}">
                                <x-slot name="title">
                                    Delete API Token
                                </x-slot>

                                <x-slot name="content">
                                    Are you sure you would like to delete this API token?
                                </x-slot>

                                <x-slot name="footer">
                                    <x-jet-secondary-button data-dismiss="modal">
                                        Nevermind
                                    </x-jet-secondary-button>

                                    <x-jet-danger-button class="ml-2"
                                                         wire:click="$emit('deleteApiToken', {{ $token->id }})"
                                                         data-dismiss="modal">
                                        Delete
                                    </x-jet-danger-button>
                                </x-slot>
                            </x-jet-confirmation-modal>
                            @push('scripts')
                                <script>
                                    Livewire.on('deleteApiToken', id => {
                                        @this.confirmApiTokenDeletion(id)
                                        @this.deleteApiToken()
                                    })
                                </script>
                            @endpush
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <!-- Token Value Modal -->
    <x-jet-dialog-modal wire:model="displayingToken">
        <x-slot name="title">
            API Token
        </x-slot>

        <x-slot name="content">
            <div>
                Please copy your new API token. For your security, it won't be shown again.
            </div>

            <div class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500">
                {{ $plainTextToken }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">
                Close
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
