<ul class="c-header-nav ml-auto mr-4">
    <!-- Teams Dropdown -->
    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
        <x-jet-dropdown id="teamManagementDropdown">
            <x-slot name="trigger">
                {{ Auth::user()->currentTeam->name }}

                <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </x-slot>

            <x-slot name="content">
                <!-- Team Management -->
                <h6 class="dropdown-header">
                    {{ __('Manage Team') }}
                </h6>

                <!-- Team Settings -->
                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                    {{ __('Team Settings') }}
                </x-jet-dropdown-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                        {{ __('Create New Team') }}
                    </x-jet-dropdown-link>
                @endcan

                <hr class="dropdown-divider">

                <!-- Team Switcher -->
                <h6 class="dropdown-header">
                    {{ __('Switch Teams') }}
                </h6>

                @foreach (Auth::user()->allTeams() as $team)
                    <x-jet-switchable-team :team="$team" />
                @endforeach
            </x-slot>
        </x-jet-dropdown>
    @endif

    <!-- Authentication Links -->
    @auth
        <x-jet-dropdown id="navbarDropdown">
            <x-slot name="trigger">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="c-avatar">
                        <img class="c-avatar-img" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @else
                    {{ Auth::user()->name }}

                    <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @endif
            </x-slot>

            <x-slot name="content">
                <div class="dropdown-header bg-light py-2">
                    <strong>{{ __('Manage Account') }}</strong>
                </div>

                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-jet-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                        {{ __('API Tokens') }}
                    </x-jet-dropdown-link>
                @endif

                <hr class="dropdown-divider">

                <!-- Authentication -->
                <x-jet-dropdown-link href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Log Out') }}
                </x-jet-dropdown-link>
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                </form>
            </x-slot>
        </x-jet-dropdown>
    @endauth
</ul>