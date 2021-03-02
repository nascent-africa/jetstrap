<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <x-nav-link href="{{ url('/') }}">
            <i class="fas fa-home"></i> {{ __('Home') }}
        </x-nav-link>

        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <i class="fas fa-desktop"></i> {{ __('Dashboard') }}
        </x-nav-link>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @auth
            <x-dropdown id="navbarDropdown" class="user-menu">
                <x-slot name="trigger">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </x-slot>

                <x-slot name="content">
                    <!-- Authentication -->
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        @endauth
    </ul>
</nav>
<!-- /.navbar -->