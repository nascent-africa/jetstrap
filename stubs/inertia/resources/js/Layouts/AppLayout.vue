<template>
  <div>
    <jet-banner />

    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
      <div class="container">
        <!-- Logo -->
        <inertia-link class="navbar-brand mr-4" :href="route('dashboard')">
          <jet-application-mark width="36" />
        </inertia-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </jet-nav-link>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto align-items-baseline">
            <!-- Team Management -->
            <jet-dropdown id="teamManagementDropdown" v-if="$page.props.jetstream.hasTeamFeatures">
              <template #trigger>
                {{ $page.props.user.current_team.name }}

                <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </template>

              <template #content>
                <!-- Team Management -->
                <template v-if="$page.props.jetstream.hasTeamFeatures">
                  <h6 class="dropdown-header">
                    Manage Team
                  </h6>

                  <!-- Team Settings -->
                  <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                    Team Settings
                  </jet-dropdown-link>

                  <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                    Create New Team
                  </jet-dropdown-link>

                  <hr class="dropdown-divider">

                  <!-- Team Switcher -->
                  <h6 class="dropdown-header">
                    Switch Teams
                  </h6>

                  <template v-for="team in $page.props.user.all_teams" :key="team.id">
                    <form @submit.prevent="switchToTeam(team)">
                      <jet-dropdown-link as="button">
                        <div class="d-flex">
                          <svg v-if="team.id == $page.props.user.current_team_id" class="mr-1 text-success" width="20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <span>{{ team.name }}</span>
                        </div>
                      </jet-dropdown-link>
                    </form>
                  </template>
                </template>
              </template>
            </jet-dropdown>

            <!-- Authentication Links -->
            <jet-dropdown id="settingsDropdown">
              <template #trigger>
                <img v-if="$page.props.jetstream.managesProfilePhotos" class="rounded-circle" width="32" height="32" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />

                <span v-else>
                  {{ $page.props.user.name }}

                  <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <h6 class="dropdown-header small text-muted">
                  Manage Account
                </h6>

                <jet-dropdown-link :href="route('profile.show')">
                  Profile
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                  API Tokens
                </jet-dropdown-link>

                <hr class="dropdown-divider">

                <!-- Authentication -->
                <form @submit.prevent="logout">
                  <jet-dropdown-link as="button">
                    Log out
                  </jet-dropdown-link>
                </form>
              </template>
            </jet-dropdown>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Heading -->
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
      <div class="container">
        <slot name="header"></slot>
      </div>
    </header>

    <!-- Page Content -->
    <main class="container my-5">
      <slot></slot>
    </main>
  </div>
</template>

<script>
import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
import JetBanner from '@/Jetstream/Banner'
import JetApplicationMark from '@/Jetstream/ApplicationMark'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetNavLink from '@/Jetstream/NavLink'

export default {
  components: {
    JetApplicationLogo,
    JetBanner,
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(route('current-team.update'), {
        'team_id': team.id
      }, {
        preserveState: false
      })
    },

    logout() {
      this.$inertia.post(route('logout'));
    },
  },

  computed: {
    path() {
      return window.location.pathname
    }
  }
}
</script>
