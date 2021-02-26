<template>
  <jet-form-section @submitted="updateTeamName">
    <template #title>
      Team Name
    </template>

    <template #description>
      The team's name and owner information.
    </template>

    <template #form>
      <jet-action-message :on="form.recentlySuccessful">
        Saved.
      </jet-action-message>

      <!-- Team Owner Information -->
      <div class="mb-3">
        <jet-label value="Team Owner" />

        <div class="d-flex items-center mt-2">
          <img class="rounded-circle mr-2" width="48" :src="team.owner.profile_photo_url" :alt="team.owner.name">

          <div>
            <div>{{ team.owner.name }}</div>
            <div class="text-muted">{{ team.owner.email }}</div>
          </div>
        </div>
      </div>

      <!-- Team Name -->
      <div class="w-75">
        <div class="form-group">
          <jet-label for="name" value="Team Name" />

          <jet-input id="name"
                     type="text"
                     class="mt-1 block w-full"
                     :class="{ 'is-invalid': form.errors.name }"
                     v-model="form.name"
                     :disabled="! permissions.canUpdateTeam" />

          <jet-input-error :message="form.errors.name" />
        </div>
      </div>
    </template>

    <template #actions v-if="permissions.canUpdateTeam">
      <jet-button :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
        Save
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
  },

  props: ['team', 'permissions'],

  data() {
    return {
      form: this.$inertia.form({
        name: this.team.name,
      })
    }
  },

  methods: {
    updateTeamName() {
      this.form.put(route('teams.update', this.team), {
        errorBag: 'updateTeamName',
        preserveScroll: true
      });
    },
  },
}
</script>
