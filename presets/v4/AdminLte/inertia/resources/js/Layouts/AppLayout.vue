<template>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
          Dashboard
        </jet-nav-link>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <jet-dropdown id="navbarDropdown" classes="nav-item dropdown user-menu">
            <template #trigger>
              <img v-if="$page.jetstream.managesProfilePhotos" class="user-image img-circle elevation-2" width="32" height="32" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
              <span class="d-none d-md-inline ml-2">{{ $page.user.name }}</span>
            </template>

            <template #content>
              <!-- Account Management -->
              <h6 class="dropdown-header small text-muted">
                Manage Account
              </h6>

              <jet-dropdown-link :href="route('profile.show')">
                Profile
              </jet-dropdown-link>

              <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                API Tokens
              </jet-dropdown-link>

              <!-- Team Management -->
              <template v-if="$page.jetstream.hasTeamFeatures">

                <hr class="dropdown-divider">

                <h6 class="dropdown-header">
                  Manage Team
                </h6>

                <!-- Team Settings -->
                <jet-dropdown-link :href="route('teams.show', $page.user.current_team)">
                  Team Settings
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('teams.create')" v-if="$page.jetstream.canCreateTeams">
                  Create New Team
                </jet-dropdown-link>

                <hr class="dropdown-divider">

                <!-- Team Switcher -->
                <h6 class="dropdown-header">
                  Switch Teams
                </h6>

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
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning elevation-2">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <jet-application-mark width="36" class="brand-image img-circle elevation-3" style="opacity: .8" />
        <span class="brand-text font-weight-light">AdminLTE</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div v-if="$page.jetstream.managesProfilePhotos" class="image">
            <img :src="$page.user.profile_photo_url" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ $page.user.name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col">
              <h1><slot name="header"></slot></h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col">
              <slot></slot>
            </div>
            <div v-show="hasSlot('aside')" class="col-lg-3">
              <slot name="aside"></slot>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b><a href="https://jetstream.laravel.com">Jetstream</a></b>
      </div>
      <strong>Powered by</strong> <a href="https://adminlte.io">AdminLTE</a>
    </footer>
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
