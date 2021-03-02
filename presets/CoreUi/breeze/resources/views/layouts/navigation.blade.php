<ul class="c-header-nav d-md-down-none">
    <li class="c-header-nav-item px-3">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
    </li>
</ul>

<ul class="c-header-nav ml-auto mr-4">
    <!-- Authentication Links -->
    @auth
        <x-dropdown id="navbarDropdown">
            <x-slot name="trigger">
                {{ Auth::user()->name }}
            </x-slot>

            <x-slot name="content">
                <!-- Authentication -->
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                </form>
                <x-dropdown-link href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    @endauth
</ul>
