<?php

namespace NascentAfrica\Jetstrap;

use Illuminate\Filesystem\Filesystem;

/**
 * Class Presets
 *
 * @package NascentAfrica\Jetstrap
 */
class Presets
{
    /**
     * @var string
     */
    const CORE_UI_3 = 'core-ui-3';

    /**
     * @var string
     */
    const ADMIN_LTE_3 = 'admin-lte-3';

    /**
     * Make Core Ui swaps
     *
     * @param string $stack
     * @return void
     */
    public static function setupCoreUi3(string $stack)
    {

        // NPM Packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                    "@coreui/coreui" => "^3.3.0",
                    "@fortawesome/fontawesome-free" => "^5.15.1",
                    "@popperjs/core" => "^2.5.3",
                    "perfect-scrollbar" => "^1.5.0"
                ] + $packages;
        });

        copy(__DIR__.'/../../../presets/webpack.mix.js', base_path('webpack.mix.js'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../presets/CoreUi/public/assets', public_path('/assets'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../presets/CoreUi/resources/sass', resource_path('sass/dashboard'));

        copy(__DIR__ . '/../../../presets/CoreUi/resources/js/dashboard.js', resource_path('js/dashboard.js'));

        if ($stack == 'livewire') {

            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));

            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/button.blade.php', resource_path('views/vendor/jetstream/components/button.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/dropdown.blade.php', resource_path('views/vendor/jetstream/components/dropdown.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/dropdown-link.blade.php', resource_path('views/vendor/jetstream/components/dropdown-link.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/nav-link.blade.php', resource_path('views/vendor/jetstream/components/nav-link.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/welcome.blade.php', resource_path('views/vendor/jetstream/components/welcome.blade.php'));

        } elseif ($stack == 'inertia') {

            // Necessary for vue compilation
            copy(__DIR__.'/../../../presets/webpack-vue.mix.js', base_path('webpack.mix.js'));

            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));

            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Button.vue', resource_path('js/Jetstream/Button.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Jetstream/Dropdown.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/DropdownLink.vue', resource_path('js/Jetstream/DropdownLink.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Jetstream/NavLink.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Welcome.vue', resource_path('js/Jetstream/Welcome.vue'));

        } elseif ($stack == 'breeze') {

            copy(__DIR__ . '/../../../presets/CoreUi/breeze/resources/views/layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/breeze/resources/views/layouts/navigation.blade.php', resource_path('views/layouts/navigation.blade.php'));

            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/dropdown.blade.php', resource_path('views/components/dropdown.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/dropdown-link.blade.php', resource_path('views/components/dropdown-link.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/nav-link.blade.php', resource_path('views/components/nav-link.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/resources/views/components/button.blade.php', resource_path('views/components/button.blade.php'));

        } elseif ($stack == 'breeze-inertia') {

            // Necessary for vue compilation
            copy(__DIR__ . '/../../../presets/webpack-vue.mix.js', base_path('webpack.mix.js'));

            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../../presets/CoreUi/breeze/inertia/resources/js/Layouts/Authenticated.vue', resource_path('js/Layouts/Authenticated.vue'));

            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Button.vue', resource_path('js/Components/Button.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Components/Dropdown.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/DropdownLink.vue', resource_path('js/Components/DropdownLink.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Components/NavLink.vue'));
            copy(__DIR__ . '/../../../presets/CoreUi/inertia/resources/js/Jetstream/Welcome.vue', resource_path('js/Components/Welcome.vue'));
        }
    }

    /**
     * Make AdminLte swaps
     *
     * @param string $stack
     * @return void
     */
    public static function setupAdminLte3(string $stack)
    {
        copy(__DIR__ . '/../../../presets/AdminLte/resources/js/dashboard.js', resource_path('js/dashboard.js'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../presets/AdminLte/resources/sass', resource_path('sass/dashboard'));

        copy(__DIR__ . '/../../../presets/webpack.mix.js', base_path('webpack.mix.js'));

        // NPM Packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                    "@fortawesome/fontawesome-free" => "^5.15.1",
                    "admin-lte" => "^3.1.0-rc",
                    "overlayscrollbars" => "^1.13.0"
                ] + $packages;
        });

        if ($stack == 'livewire') {

            (new Filesystem)->copyDirectory(__DIR__.'/../../../presets/AdminLte/resources/views/auth', resource_path('views/auth'));

            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));

            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/components/dropdown.blade.php', resource_path('views/vendor/jetstream/components/dropdown.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/components/nav-link.blade.php', resource_path('views/vendor/jetstream/components/nav-link.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/components/welcome.blade.php', resource_path('views/vendor/jetstream/components/welcome.blade.php'));

        } elseif ($stack == 'inertia') {

            // Necessary for vue compilation
            copy(__DIR__.'/../../../presets/webpack-vue.mix.js', base_path('webpack.mix.js'));

            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Layouts/AppLayout.vue', resource_path('js/Layouts/AppLayout.vue'));

            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Jetstream/Dropdown.vue'));
            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Jetstream/NavLink.vue'));
            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/Welcome.vue', resource_path('js/Jetstream/Welcome.vue'));

        } elseif ($stack == 'breeze') {

            copy(__DIR__ . '/../../../presets/AdminLte/breeze/resources/views/layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/breeze/resources/views/layouts/navigation.blade.php', resource_path('views/layouts/navigation.blade.php'));

            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/components/dropdown.blade.php', resource_path('views/components/dropdown.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/resources/views/components/nav-link.blade.php', resource_path('views/components/nav-link.blade.php'));

        } elseif ($stack == 'breeze-inertia') {

            // Necessary for vue compilation
            copy(__DIR__.'/../../../presets/webpack-vue.mix.js', base_path('webpack.mix.js'));

            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
            copy(__DIR__ . '/../../../presets/AdminLte/breeze/inertia/resources/js/Layouts/Authenticated.vue', resource_path('js/Layouts/Authenticated.vue'));

            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Components/Dropdown.vue'));
            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Components/NavLink.vue'));
            copy(__DIR__ . '/../../../presets/AdminLte/inertia/resources/js/Jetstream/Welcome.vue', resource_path('js/Components/Welcome.vue'));

        }
    }
}