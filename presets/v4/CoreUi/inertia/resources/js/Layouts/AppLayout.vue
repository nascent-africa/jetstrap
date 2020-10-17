<template>
  <div>
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
            <jet-nav-link :href="route('dashboard')" :active="$page.currentRouteName == 'dashboard'">
              Dashboard
            </jet-nav-link>
          </li>
        </ul>

        <ul class="c-header-nav ml-auto mr-4">
          <!-- Authentication Links -->
          <jet-dropdown id="navbarDropdown">
            <template #trigger>
              <div v-if="$page.jetstream.managesProfilePhotos" class="c-avatar">
                <img class="c-avatar-img" width="32" height="32" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
              </div>
              <span v-else>{{ $page.user.name }}</span>
            </template>

            <template #content>
              <!-- Account Management -->
              <div class="dropdown-header bg-light py-2">
                <strong>Manage Account</strong>
              </div>

              <jet-dropdown-link :href="route('profile.show')">
                Profile
              </jet-dropdown-link>

              <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                API Tokens
              </jet-dropdown-link>

              <!-- Team Management -->
              <template v-if="$page.jetstream.hasTeamFeatures">

                <div class="dropdown-header bg-light py-2">
                  <strong>Manage Team</strong>
                </div>

                <!-- Team Settings -->
                <jet-dropdown-link :href="route('teams.show', $page.user.current_team)">
                  Team Settings
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('teams.create')" v-if="$page.jetstream.canCreateTeams">
                  Create New Team
                </jet-dropdown-link>

                <!-- Team Switcher -->
                <div class="dropdown-header bg-light py-2">
                  <strong>Switch Teams</strong>
                </div>

                <template v-for="team in $page.user.all_teams">
                  <form @submit.prevent="switchToTeam(team)">
                    <jet-dropdown-link as="button">
                      <div class="d-flex">
                        <svg v-if="team.id == $page.user.current_team_id" class="mr-1 text-success" width="20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ team.name }}</span>
                      </div>
                    </jet-dropdown-link>
                  </form>
                </template>
              </template>

              <hr class="dropdown-divider">

              <!-- Authentication -->
              <form @submit.prevent="logout">
                <jet-dropdown-link as="button">
                  Logout
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

      <!-- Modal Portal -->
      <portal-target name="modal" multiple>
      </portal-target>
    </div>
  </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'
    import JetApplicationMark from './../Jetstream/ApplicationMark'
    import JetDropdown from './../Jetstream/Dropdown'
    import JetDropdownLink from './../Jetstream/DropdownLink'
    import JetNavLink from './../Jetstream/NavLink'

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
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },

            hasSlot (name = 'default') {
              return !!this.$slots[ name ] || !!this.$scopedSlots[ name ];
            },
        },

        computed: {
            path() {
                return window.location.pathname
            }
        }
    }
</script>
