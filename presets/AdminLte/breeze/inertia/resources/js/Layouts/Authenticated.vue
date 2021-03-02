<template>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <breeze-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
          Dashboard
        </breeze-nav-link>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <breeze-dropdown id="settingsDropdown" classes="nav-item dropdown user-menu">
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
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning elevation-2">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <breeze-application-logo width="36" class="brand-image img-circle elevation-1" style="opacity: .8" />
        <span class="brand-text font-weight-light">AdminLTE</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <!-- <div v-if="" class="image">
            &lt;!&ndash; <img :src="" class="img-circle elevation-1" alt="User Image">&ndash;&gt;
          </div>-->
          <div class="info">
            <a href="#" class="d-block">{{ $page.props.user.name }}</a>
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
          <breeze-banner />

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
        <b><a href="https://github.com/laravel/breeze">Breeze</a></b>
      </div>
      <strong>Powered by</strong> <a href="https://adminlte.io">AdminLTE</a>
    </footer>
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
