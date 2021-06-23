<?php

namespace NascentAfrica\Jetstrap\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use NascentAfrica\Jetstrap\Helpers;
use NascentAfrica\Jetstrap\JetstrapFacade;
use NascentAfrica\Jetstrap\Presets;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jetstrap:swap {stack : The development stack that should be installed}
                                              {--teams : Indicates if team support should be installed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swap TailwindCss for Bootstrap 4.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Performing swap...');

        // Remove Tailwind Configuration...
        if ((new Filesystem)->exists(base_path('tailwind.config.js'))) {
            (new Filesystem)->delete(base_path('tailwind.config.js'));
        }

        // Bootstrap Configuration...
        copy(__DIR__.'/../../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../../../stubs/webpack.config.js', base_path('webpack.config.js'));

        // Assets...
        (new Filesystem)->deleteDirectory(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/resources/js', resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/resources/sass', resource_path('sass'));

        copy(__DIR__.'/../../../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {

            $this->swapJetstreamLivewireStack();

        } elseif ($this->argument('stack') === 'inertia') {

            $this->swapJetstreamInertiaStack();
        } elseif ($this->argument('stack') === 'breeze') {

            $this->swapBreezeStack();
        } elseif ($this->argument('stack') === 'breeze-inertia') {

            $this->swapBreezeInertiaStack();
        }
    }

    /**
     * Swap the Livewire stack into the application.
     *
     * @return void
     */
    protected function swapJetstreamLivewireStack()
    {
        $this->line('');
        $this->info('Installing livewire stack...');

        Helpers::updateNodePackages(function ($packages) {
            return [
                'alpinejs' => '^3.0.6',
                'bootstrap' => '^4.6.0',
                'jquery' => '^3.5.1',
                'popper.js' => '^1.16.1'
            ] + $packages;
        });

        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));

        // Layouts
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/livewire/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/livewire/resources/views/api', resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/livewire/resources/views/profile', resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/livewire/resources/views/auth', resource_path('views/auth'));

        // Single Blade Views...
        copy(__DIR__.'/../../../../stubs/livewire/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
        copy(__DIR__.'/../../../../stubs/livewire/resources/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));
        copy(__DIR__.'/../../../../stubs/livewire/resources/views/terms.blade.php', resource_path('views/terms.blade.php'));
        copy(__DIR__.'/../../../../stubs/livewire/resources/views/policy.blade.php', resource_path('views/policy.blade.php'));

        // Assets...
        (new Filesystem)->copy(__DIR__.'/../../../../stubs/resources/js/app.js', resource_path('js/app.js'));

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'jetstrap-views', '--force' => true]);

        // Teams...
        if ($this->option('teams')) {
            $this->swapJetstreamLivewireTeamStack();
        }

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->line('');
        $this->info('Bootstrap scaffolding swapped for livewire successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Swap the Livewire team stack into the application.
     *
     * @return void
     */
    protected function swapJetstreamLivewireTeamStack()
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/teams'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/livewire/resources/views/teams', resource_path('views/teams'));
    }

    /**
     * Swap the Inertia stack into the application.
     *
     * @return void
     */
    protected function swapJetstreamInertiaStack()
    {
        $this->line('');
        $this->info('Installing inertia stack...');

        // Install NPM packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                '@inertiajs/inertia' => '^0.9.1',
                '@inertiajs/inertia-vue3' => '^0.4.2',
                '@inertiajs/progress' => '^0.2.5',
                'alpinejs' => '^3.0.6',
                'bootstrap' => '^4.6.0',
                'jquery' => '^3.5.1',
                'popper.js' => '^1.16.1',
                'vue' => '^3.0.5',
                '@vue/compiler-sfc' => '^3.0.5',
                'vue-loader' => '^16.1.2',
            ] + $packages;
        });

        // Necessary for vue compilation
        copy(__DIR__.'/../../../../stubs/inertia/webpack.mix.js', base_path('webpack.mix.js'));

        // Blade Views...
        copy(__DIR__.'/../../../../stubs/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        // Assets...
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));

        (new Filesystem)->ensureDirectoryExists(resource_path('js/Jetstream'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/API'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));

        if (file_exists(resource_path('views/welcome.blade.php'))) {
            unlink(resource_path('views/welcome.blade.php'));
        }

        // Inertia Pages...
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/Dashboard.vue', resource_path('js/Pages/Dashboard.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/PrivacyPolicy.vue', resource_path('js/Pages/PrivacyPolicy.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/TermsOfService.vue', resource_path('js/Pages/TermsOfService.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/Welcome.vue', resource_path('js/Pages/Welcome.vue'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream', resource_path('js/Jetstream'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/API', resource_path('js/Pages/API'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/Auth', resource_path('js/Pages/Auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));


        // Teams...
        if ($this->option('teams')) {
            $this->swapJetstreamInertiaTeamStack();
        }

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->line('');
        $this->info('Bootstrap scaffolding swapped for inertia successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Swap the Inertia team stack into the application.
     *
     * @return void
     */
    protected function swapJetstreamInertiaTeamStack()
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Profile'));

        // Pages...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
    }

    /**
     * Swap TailwindCss resources in Laravel Breeze.
     *
     * @return void
     */
    protected function swapBreezeStack()
    {
        // NPM Packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                    'alpinejs' => '^2.7.3',
                    'bootstrap' => '^4.6.0',
                    'jquery' => '^3.5.1',
                    'popper.js' => '^1.16.1'
                ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/resources/views/components', resource_path('views/components'));

        copy(__DIR__.'/../../../../breeze/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
        copy(__DIR__.'/../../../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->info('Breeze scaffolding swapped successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Install the Inertia Breeze stack.
     *
     * @return void
     */
    protected function swapBreezeInertiaStack()
    {
        // NPM Packages...
        Helpers::updateNodePackages(function ($packages) {
            return [
                '@inertiajs/inertia' => '^0.8.2',
                '@inertiajs/inertia-vue3' => '^0.3.5',
                'alpinejs' => '^2.7.3',
                'bootstrap' => '^4.6.0',
                'jquery' => '^3.5.1',
                'popper.js' => '^1.16.1',
                'vue' => '^3.0.5',
                '@vue/compiler-sfc' => '^3.0.5',
                'vue-loader' => '^16.1.2',
            ] + $packages;
        });

        // Views...
        copy(__DIR__.'/../../../../stubs/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        copy(__DIR__.'/../../../../stubs/inertia/webpack.mix.js', base_path('webpack.mix.js'));

        // Assets...
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));

        // Components + Pages...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/inertia/resources/js/Components', resource_path('js/Components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/inertia/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../breeze/inertia/resources/js/Pages', resource_path('js/Pages'));

        if ((new Filesystem)->exists(resource_path('js/Components/ResponsiveNavLink.vue'))) {
            (new Filesystem)->delete(resource_path('js/Components/ResponsiveNavLink.vue'));
        }

        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/Button.vue', resource_path('js/Components/Button.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/Checkbox.vue', resource_path('js/Components/Checkbox.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/Dropdown.vue', resource_path('js/Components/Dropdown.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/DropdownLink.vue', resource_path('js/Components/DropdownLink.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/Input.vue', resource_path('js/Components/Input.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/InputError.vue', resource_path('js/Components/InputError.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/Label.vue', resource_path('js/Components/Label.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/NavLink.vue', resource_path('js/Components/NavLink.vue'));
        copy(__DIR__.'/../../../../stubs/inertia/resources/js/Jetstream/ValidationErrors.vue', resource_path('js/Components/ValidationErrors.vue'));

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->info('Breeze scaffolding swapped successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Install third party presets.
     *
     * @return void
     */
    protected function installPreset()
    {
        // Check for preset usage...
        if ($preset = JetstrapFacade::getPreset()) {
            switch ($preset) {
                case Presets::CORE_UI_3:
                    $this->line('');
                    $this->info('Setting up Core Ui 3.');
                    Presets::setupCoreUi3($this->argument('stack'));
                    break;
                case Presets::ADMIN_LTE_3:
                    $this->line('');
                    $this->info('Setting up AdminLte 3.');
                    Presets::setupAdminLte3($this->argument('stack'));
                    break;
            }
        }
    }
}
