<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/core-ui.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/core-ui.js') }}" defer></script>
    </head>
    <body class="c-app">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
            <div class="c-sidebar-brand">
                <a href="/">
                    <x-jet-application-mark class="c-sidebar-brand-minimized" width="36" />
                    <x-jet-application-mark class="c-sidebar-brand-full" width="36" />
                </a>
            </div>

            <ul class="c-sidebar-nav">
                {{ $sidebar ?? '' }}
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
                        <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-jet-nav-link>
                    </li>
                </ul>

                <ul class="c-header-nav ml-auto mr-4">
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

                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                    <h6 class="dropdown-header bg-light py-2">
                                        <strong>{{ __('Manage Team') }}</strong>
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

                                    <!-- Team Switcher -->
                                    <h6 class="dropdown-header bg-light py-2">
                                        <strong>{{ __('Switch Teams') }}</strong>
                                    </h6>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                @endif

                                <hr class="dropdown-divider">

                                <!-- Authentication -->
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </x-jet-dropdown-link>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    @endauth
                </ul>

                <div class="c-subheader px-3 py-3">
                    <div class="container">
                        {{ $header }}
                    </div>
                </div>
            </header>

          <div class="c-body">
            <main class="c-main">

              <div class="container">
                  <div class="row fade-in">
                      <div class="col">
                          {{ $slot }}
                      </div>

                      @if (isset($aside))
                          <div class="col-lg-3">
                              {{ $aside ?? '' }}
                          </div>
                      @endif
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

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
