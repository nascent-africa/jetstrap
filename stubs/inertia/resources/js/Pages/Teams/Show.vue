<template>
  <app-layout>
    <template #header>
      <h2 class="h4 font-weight-bold">
        Team Settings
      </h2>
    </template>

    <update-team-name-form :team="team" :permissions="permissions" />

    <team-member-manager :team="team"
                         :available-roles="availableRoles"
                         :user-permissions="permissions" />

    <template v-if="permissions.canDeleteTeam && ! team.personal_team">
      <jet-section-border />

      <delete-team-form :team="team" />
    </template>
  </app-layout>
</template>

<script>
import TeamMemberManager from './TeamMemberManager'
import AppLayout from '@/Layouts/AppLayout'
import DeleteTeamForm from './DeleteTeamForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import UpdateTeamNameForm from './UpdateTeamNameForm'

export default {
  props: [
    'team',
    'availableRoles',
    'permissions',
  ],

  components: {
    AppLayout,
    DeleteTeamForm,
    JetSectionBorder,
    TeamMemberManager,
    UpdateTeamNameForm,
  },
}
</script>
