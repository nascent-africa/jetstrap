<?php

namespace NascentAfrica\Jetstrap;

use Illuminate\Filesystem\Filesystem;

class CoreUi
{
    /**
     * Make Core Ui swaps
     *
     * @param string $stack
     * @return void
     */
    public static function setupCoreUi3(string $stack)
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../presets/v4/CoreUi/public/assets', public_path('/assets'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../presets/v4/CoreUi/resources/sass', resource_path('sass/core-ui'));

        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/js/core-ui.js', resource_path('js/core-ui.js'));

        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/auth/login.blade.php', resource_path('views/auth/login.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/auth/register.blade.php', resource_path('views/auth/register.blade.php'));

        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/authentication-card.blade.php', resource_path('views/vendor/jetstream/components/authentication-card.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/button.blade.php', resource_path('views/vendor/jetstream/components/button.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/dropdown.blade.php', resource_path('views/vendor/jetstream/components/dropdown.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/dropdown-link.blade.php', resource_path('views/vendor/jetstream/components/dropdown-link.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/nav-link.blade.php', resource_path('views/vendor/jetstream/components/nav-link.blade.php'));
        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/components/welcome.blade.php', resource_path('views/vendor/jetstream/components/welcome.blade.php'));

        copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/layouts/guest.blade.php', resource_path('views/layouts/guest.blade.php'));

        if ($stack == 'livewire') {
            copy(__DIR__ . '/../../presets/v4/CoreUi/resources/views/layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));
        } elseif ($stack == 'inertia') {
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));

            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Jetstream/Button.vue', resource_path('js/Jetstream/Button.vue'));
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Jetstream/Dropdown.vue'));
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Jetstream/DropdownLink.vue', resource_path('js/Jetstream/DropdownLink.vue'));
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Jetstream/NavLink.vue'));
            copy(__DIR__ . '/../../presets/v4/CoreUi/inertia/resources/js/Jetstream/Welcome.vue', resource_path('js/Jetstream/Welcome.vue'));
        }

        copy(__DIR__.'/../../presets/v4/CoreUi/webpack.mix.js', base_path('webpack.mix.js'));

        // NPM Packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                    "@coreui/coreui" => "^3.3.0",
                    "@fortawesome/fontawesome-free" => "^5.15.1",
                    "@popperjs/core" => "^2.5.3",
                    "perfect-scrollbar" => "^1.5.0"
                ] + $packages;
        });
    }
}