<x-jet-action-section>
    <x-slot name="title">
        Delete Account
    </x-slot>

    <x-slot name="description">
        Permanently delete your account.
    </x-slot>

    <x-slot name="content">
        <div>
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="$emit('confirmingUserDeletion')"
                                 wire:loading.attr="disabled">
                Delete Account
            </x-jet-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal id="confirmingUserDeletionModal">
            <x-slot name="title">
                Delete Account
            </x-slot>

            <x-slot name="content">
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password"
                                 x-ref="password"
                                 wire:model.defer="password"
                                 wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')"
                                        wire:loading.attr="disabled"
                                        data-dismiss="modal">
                    Nevermind
                </x-jet-secondary-button>

                <x-jet-danger-button wire:click="deleteUser" wire:loading.attr="disabled">
                    Delete Account
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>

    @push('scripts')
        <script>
            Livewire.on('confirmingUserDeletion', () => {
                @this.confirmUserDeletion()
                new Bootstrap.Modal(document.getElementById('confirmingUserDeletionModal')).toggle()
            })
        </script>
    @endpush
</x-jet-action-section>
