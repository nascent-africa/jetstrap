<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/dashboard.js') }}" defer></script>
    </head>
    <body class="c-app font-sans antialiased">
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

                @livewire('navigation-menu')

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
