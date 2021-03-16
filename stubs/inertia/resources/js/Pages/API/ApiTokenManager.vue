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
        <jet-action-message :on="createApiTokenForm.recentlySuccessful">
          Created.
        </jet-action-message>

        <div class="w-75">
          <!-- Token Name -->
          <div class="form-group">
            <jet-label for="name" value="Name" />
            <jet-input id="name" type="text" v-model="createApiTokenForm.name" autofocus
                       :class="{ 'is-invalid': createApiTokenForm.errors.name }" />
            <jet-input-error :message="createApiTokenForm.errors.name" />
          </div>

          <!-- Token Permissions -->
          <div v-if="availablePermissions.length > 0">
            <jet-label for="permissions" value="Permissions" />

            <div class="mt-2 row">
              <div class="col-6" v-for="permission in availablePermissions" :key="permission">
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <jet-checkbox :value="permission" v-model:checked="createApiTokenForm.permissions" :id="`create-${permission}`"/>
                    <label class="custom-control-label" :for="`create-${permission}`">
                      {{ permission }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template #actions>
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
              <div class="d-flex justify-content-between" v-for="token in tokens" :key="token.id">
                <div>
                  {{ token.name }}
                </div>

                <div class="d-flex">
                  <div class="text-sm text-muted" v-if="token.last_used_ago">
                    Last used {{ token.last_used_ago }}
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

        <div class="bg-light rounded p-3 user-select-all" v-if="$page.props.jetstream.flash.token">
          {{ $page.props.jetstream.flash.token }}
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click="displayingToken = false" data-dismiss="modal">
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
          <div class="col-6" v-for="permission in availablePermissions" :key="permission">
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <jet-checkbox :value="permission" v-model:checked="updateApiTokenForm.permissions" :id="`update-${permission}`"/>
                <label class="custom-control-label" :for="`update-${permission}`">
                  {{ permission }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template #footer>
        <jet-secondary-button data-dismiss="modal" @click="managingPermissionsFor = null">
          Cancel
        </jet-secondary-button>

        <jet-button class="ml-2" @click="updateApiToken" :class="{ 'text-black-50': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
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
        <jet-secondary-button @click="apiTokenBeingDeleted = null" data-dismiss="modal">
          Cancel
        </jet-secondary-button>

        <jet-danger-button class="ml-2" @click="deleteApiToken" :class="{ 'text-white-50': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
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
  import JetCheckbox from '@/Jetstream/Checkbox'
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
      JetCheckbox,
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
        }),

        updateApiTokenForm: this.$inertia.form({
          permissions: []
        }),

        deleteApiTokenForm: this.$inertia.form(),

        managingPermissionsFor: null,
        apiTokenBeingDeleted: null,
        bootstrap: null
      }
    },

    methods: {
      createApiToken() {
        this.createApiTokenForm.post(route('api-tokens.store'), {
          preserveScroll: true,
          onSuccess: () => {
            this.createApiTokenForm.reset()
            this.bootstrap = $('#displayingTokenModal')
            this.bootstrap.modal('toggle')
          }
        })
      },

      manageApiTokenPermissions(token) {
        this.updateApiTokenForm.permissions = token.abilities
        this.managingPermissionsFor = token
        this.bootstrap = $('#managingPermissionsForModal')
        this.bootstrap.modal('toggle')
      },

      updateApiToken() {
        this.updateApiTokenForm.put(route('api-tokens.update', this.managingPermissionsFor), {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.managingPermissionsFor = null),
        })
      },

      confirmApiTokenDeletion(token) {
        this.apiTokenBeingDeleted = token
        this.bootstrap = $('#apiTokenBeingDeletedModal')
        this.bootstrap.modal('toggle')
      },

      deleteApiToken() {
        this.deleteApiTokenForm.delete(route('api-tokens.destroy', this.apiTokenBeingDeleted), {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => {
            this.apiTokenBeingDeleted = null
            this.bootstrap.modal('toggle')
          },
        })
      },
    }
  }
</script>
