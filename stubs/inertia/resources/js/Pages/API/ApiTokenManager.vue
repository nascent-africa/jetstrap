<template>
    <div>
        <!-- Generate API Token -->
        <jet-form-section @submitted="createApiToken">
            <template #title>
                Create API Token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <template #form>
                <div class="w-75">
                    <!-- Token Name -->
                    <div class="mb-3">
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" v-model="createApiTokenForm.name" autofocus
                                   :class="{ 'is-invalid': createApiTokenForm.error('name') }" />
                        <jet-input-error :message="createApiTokenForm.error('name')" />
                    </div>

                    <!-- Token Permissions -->
                    <div v-if="availablePermissions.length > 0">
                    <jet-label for="permissions" value="Permissions" />

                    <div class="mt-2 row">
                        <div class="col-6" v-for="permission in availablePermissions">
                            <div class="form-check">
                                <input :id="`check-permissions-${permission}`" type="checkbox" class="form-check-input"
                                       :value="permission" v-model="createApiTokenForm.permissions">
                                <label class="form-check-label" :for="`check-permissions-${permission}`">
                                    {{ permission }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </template>

            <template #actions>
                <jet-action-message :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </jet-action-message>

                <jet-button :class="{ 'text-white-50': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </jet-button>
            </template>
        </jet-form-section>

        <div v-if="tokens.length > 0">
            <jet-section-border />

            <!-- Manage API Tokens -->
            <div>
                <jet-action-section>
                    <template #title>
                        Manage API Tokens
                    </template>

                    <template #description>
                        You may delete any of your existing tokens if they are no longer needed.
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div>
                            <div class="d-flex justify-content-between" v-for="token in tokens">
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="d-flex">
                                    <div class="text-sm text-muted" v-if="token.last_used_at">
                                        Last used {{ fromNow(token.last_used_at) }}
                                    </div>

                                    <button class="btn btn-link text-secondary"
                                                @click="manageApiTokenPermissions(token)"
                                                v-if="availablePermissions.length > 0">
                                        Permissions
                                    </button>

                                    <button class="btn btn-link text-danger text-decoration-none" @click="confirmApiTokenDeletion(token)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </jet-action-section>
            </div>
        </div>

        <!-- Token Value Modal -->
        <jet-dialog-modal id="displayingTokenModal">
            <template #title>
                API Token
            </template>

            <template #content>
                <div>
                    Please copy your new API token. For your security, it won't be shown again.
                </div>

                <div class="bg-light rounded p-3 user-select-all" v-if="$page.jetstream.flash.token">
                    {{ $page.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <jet-secondary-button data-dismiss="modal">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <!-- API Token Permissions Modal -->
        <jet-dialog-modal id="managingPermissionsForModal">
            <template #title>
                API Token Permissions
            </template>

            <template #content>
                <div class="mt-2 row">
                    <div class="col-6" v-for="permission in availablePermissions">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" :value="permission" v-model="updateApiTokenForm.permissions">
                            <label class="form-check-label">
                                {{ permission }}
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button data-dismiss="modal">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="updateApiToken" :class="{ 'text-black-50': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>

        <!-- Delete Token Confirmation Modal -->
        <jet-confirmation-modal id="apiTokenBeingDeletedModal">
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #footer>
                <jet-secondary-button data-dismiss="modal">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteApiToken" :class="{ 'text-white-50': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
        },

        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],

        data() {
            return {
                createApiTokenForm: this.$inertia.form({
                    name: '',
                    permissions: this.defaultPermissions,
                }, {
                    bag: 'createApiToken',
                    resetOnSuccess: true,
                }),

                updateApiTokenForm: this.$inertia.form({
                    permissions: []
                }, {
                    resetOnSuccess: false,
                    bag: 'updateApiToken',
                }),

                deleteApiTokenForm: this.$inertia.form(),

                managingPermissionsFor: null,
                apiTokenBeingDeleted: null,
            }
        },

        methods: {
            createApiToken() {
                this.createApiTokenForm.post(route('api-tokens.store'), {
                    preserveScroll: true,
                }).then(response => {
                    if (! this.createApiTokenForm.hasErrors()) {
                        this.modal = new Bootstrap.Modal(document.getElementById('displayingTokenModal'))
                        this.modal.toggle()
                    }
                })
            },

            manageApiTokenPermissions(token) {
                this.updateApiTokenForm.permissions = token.abilities

                this.managingPermissionsFor = token

                this.modal = new Bootstrap.Modal(document.getElementById('managingPermissionsForModal'))
                this.modal.toggle()
            },

            updateApiToken() {
                this.updateApiTokenForm.put(route('api-tokens.update', this.managingPermissionsFor), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(response => {
                    this.modal.toggle()
                })
            },

            confirmApiTokenDeletion(token) {
                this.apiTokenBeingDeleted = token
                this.modal = new Bootstrap.Modal(document.getElementById('apiTokenBeingDeletedModal'))
                this.modal.toggle()
            },

            deleteApiToken() {
                this.deleteApiTokenForm.delete(route('api-tokens.destroy', this.apiTokenBeingDeleted), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(() => {
                    this.apiTokenBeingDeleted = null
                    this.modal.toggle()
                })
            },

            fromNow(timestamp) {
                return moment(timestamp).local().fromNow()
            },
        },
    }
</script>
