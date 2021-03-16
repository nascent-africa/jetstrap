<template>
  <jet-action-section>
    <template #title>
      Delete Team
    </template>

    <template #description>
      Permanently delete this team.
    </template>

    <template #content>
      <div>
        Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
      </div>

      <div class="mt-3">
        <jet-danger-button @click="confirmTeamDeletion">
          Delete Team
        </jet-danger-button>
      </div>

      <!-- Delete Team Confirmation Modal -->
      <jet-confirmation-modal id="confirmingTeamDeletionModal">
        <template #title>
          Delete Team
        </template>

        <template #content>
          Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
          <jet-secondary-button data-dismiss="modal">
            Cancel
          </jet-secondary-button>

          <jet-danger-button class="ml-2" @click="deleteTeam" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
            Delete Team
          </jet-danger-button>
        </template>
      </jet-confirmation-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetButton from '@/Jetstream/Button'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
  props: ['team'],

  components: {
    JetActionSection,
    JetButton,
    JetConfirmationModal,
    JetDangerButton,
    JetSecondaryButton,
  },

  data() {
    return {
      bootstrap: null,
      deleting: false,

      form: this.$inertia.form()
    }
  },

  methods: {
    confirmTeamDeletion() {
      this.bootstrap = $('#confirmingTeamDeletionModal')
      this.bootstrap.modal('toggle')
    },

    deleteTeam() {
      this.form.delete(route('teams.destroy', this.team), {
        errorBag: 'deleteTeam',
        onSuccess: () => this.bootstrap.modal('toggle')
      });
    },
  },
}
</script>
