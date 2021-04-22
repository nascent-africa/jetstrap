<template>
  <div style="width: 100%">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      <div class="c-sidebar-brand">
        <a href="/">
          <jet-application-mark class="c-sidebar-brand-minimized" width="36" />
          <jet-application-mark class="c-sidebar-brand-full" width="36" />
        </a>
      </div>

      <ul class="c-sidebar-nav">
        <slot name="sidebar"></slot>
      </ul>

      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
          <span class="c-header-toggler-icon"></span>
        </button>

        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
          <span class="c-header-toggler-icon"></span>
        </button>

        <ul class="c-header-nav d-md-down-none">
          <li class="c-header-nav-item px-3">
            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </jet-nav-link>
          </li>
        </ul>

        <ul class="c-header-nav ml-auto mr-4">
          <!-- Team Management -->
          <jet-dropdown id="teamManagementDropdown">
            <template #trigger>
              {{ $page.props.user.current_team.name }}

              <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </template>

            <template #content>
              <template v-if="$page.props.jetstream.hasTeamFeatures">

                <div class="dropdown-header bg-light py-2">
                  <strong>Manage Team</strong>
                </div>

                <!-- Team Settings -->
                <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                  Team Settings
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                  Create New Team
                </jet-dropdown-link>

                <!-- Team Switcher -->
                <div class="dropdown-header bg-light py-2">
                  <strong>Switch Teams</strong>
                </div>

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
              <div v-if="$page.props.jetstream.managesProfilePhotos" class="c-avatar">
                <img class="c-avatar-img" width="32" height="32" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
              </div>
              <span v-else>{{ $page.props.user.name }}</span>

              <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </template>

            <template #content>
              <!-- Account Management -->
              <div class="dropdown-header bg-light py-2">
                <strong>Manage Account</strong>
              </div>

              <jet-dropdown-link :href="route('profile.show')">
                Profile
              </jet-dropdown-link>

              <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                API Tokens
              </jet-dropdown-link>

              <!-- Authentication -->
              <form @submit.prevent="logout">
                <jet-dropdown-link as="button">
                  Log out
                </jet-dropdown-link>
              </form>
            </template>
          </jet-dropdown>
        </ul>

        <div class="c-subheader px-3 py-3">
          <div class="container">
            <slot name="header"></slot>
          </div>
        </div>
      </header>

      <div class="c-body">
        <main class="c-main">

          <div class="container">
            <div class="row fade-in">
              <div class="col">
                <slot></slot>
              </div>

              <div v-if="hasSlot('aside')" class="col-lg-3">
                <slot name="aside"></slot>
              </div>
            </div>
          </div>

        </main>

        <footer class="c-footer">
          <div>
            <a href="https://jetstream.laravel.com/1.x/introduction.html">Jetstream</a> © 2020 Laravel.
          </div>
          <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
import JetApplicationMark from '@/Jetstream/ApplicationMark'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetNavLink from '@/Jetstream/NavLink'

export default {
  components: {
    JetApplicationLogo,
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

    hasSlot (name = 'default') {
      return !!this.$slots[ name ];
    },
  },

  computed: {
    path() {
      return window.location.pathname
    }
  }
}
</script>
