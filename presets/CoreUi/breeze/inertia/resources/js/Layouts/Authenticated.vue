<template>
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand">
      <a href="/">
        <breeze-application-logo class="c-sidebar-brand-minimized" width="36" />
        <breeze-application-logo class="c-sidebar-brand-full" width="36" />
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
          <breeze-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
            Dashboard
          </breeze-nav-link>
        </li>
      </ul>

      <ul class="c-header-nav ml-auto mr-4">
        <!-- Authentication Links -->
        <breeze-dropdown id="settingsDropdown">
          <template #trigger>
            {{ $page.props.auth.user.name }}

            <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </template>

          <template #content>
            <!-- Authentication -->
            <breeze-dropdown-link :href="route('logout')" method="post">
              Log Out
            </breeze-dropdown-link>
          </template>
        </breeze-dropdown>
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
          <a href="https://github.com/laravel/breeze">Breeze</a> © 2020 Laravel.
        </div>
        <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
      </footer>
    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo'
import BreezeDropdown from '@/Components/Dropdown'
import BreezeDropdownLink from '@/Components/DropdownLink'
import BreezeNavLink from '@/Components/NavLink'

export default {
  components: {
    BreezeApplicationLogo,
    BreezeDropdown,
    BreezeDropdownLink,
    BreezeNavLink
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },

  methods: {
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
