<template>
    <jet-action-section>
        <template #title>
            Delete Account
        </template>

        <template #description>
            Permanently delete your account.
        </template>

        <template #content>
            <div>
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </div>

            <div class="mt-3">
                <jet-danger-button @click.native="confirmUserDeletion">
                    Delete Account
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal id="confirmingUserDeletionModal">
                <template #title>
                    Delete Account
                </template>

                <template #content>
                    Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

                    <div class="mt-4">
                        <jet-input type="password" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                   :class="{ 'is-invalid': form.error('password') }"
                                    @keyup.enter.native="deleteUser" />

                        <jet-input-error :message="form.error('password')" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button data-dismiss="modal">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button @click.native="deleteUser" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                        Delete Account
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionSection,
            JetButton,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        data() {
            return {
                modal: null,

                deleting: false,

                form: this.$inertia.form({
                    '_method': 'DELETE',
                    password: '',
                }, {
                    bag: 'deleteUser'
                })
            }
        },

        methods: {
            confirmUserDeletion() {
                this.form.password = '';

                this.modal = new Bootstrap.Modal(document.getElementById('confirmingUserDeletionModal'))

                this.modal.toggle()

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            deleteUser() {
                this.form.post(route('current-user.destroy'), {
                    preserveScroll: true
                }).then(response => {
                    if (! this.form.hasErrors()) {
                        this.modal.toggle()
                    }
                })
            },
        },
    }
</script>
