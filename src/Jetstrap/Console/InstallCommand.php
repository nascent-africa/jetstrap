<?php

namespace NascentAfrica\Jetstrap\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use NascentAfrica\Jetstrap\Helpers;
use NascentAfrica\Jetstrap\JetstrapFacade;
use NascentAfrica\Jetstrap\JetstrapFacade as Jetstrap;
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
    protected $description = 'Swap TailwindCss for Bootstrap 4 or 5.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Performing swap...');

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'jetstrap-views', '--force' => true]);

        copy(__DIR__.'/../../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        // Remove Tailwind Configuration...
        if ((new Filesystem)->exists(base_path('tailwind.config.js'))) {
            (new Filesystem)->delete(base_path('tailwind.config.js'));
        }

        // Bootstrap Configuration...
        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        // Assets...
        (new Filesystem)->deleteDirectory(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js'));

        if (Jetstrap::isBootstrap4()) {
            $this->line('');
            $this->info('Setting up bootstrap 4');

            copy(__DIR__.'/../../../resources/v4/views/components/dialog-modal.blade.php', resource_path('views/vendor/jetstream/components/dialog-modal.blade.php'));
            copy(__DIR__.'/../../../resources/v4/views/components/label.blade.php', resource_path('views/vendor/jetstream/components/label.blade.php'));

            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/resources/views/auth', resource_path('views/auth'));

            copy(__DIR__.'/../../../stubs/v4/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/resources/sass', resource_path('sass'));

            if ($this->argument('stack') === 'livewire') {
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/livewire/resources/views/api', resource_path('views/api'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/livewire/resources/views/profile', resource_path('views/profile'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/livewire/resources/views/teams', resource_path('views/teams'));
            } elseif ($this->argument('stack') === 'inertia') {
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/inertia/resources/js/Pages/API', resource_path('js/Pages/API'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
            }

        } elseif (Jetstrap::isBootstrap5()) {
            $this->line('');
            $this->info('Setting up bootstrap 5');

            copy(__DIR__.'/../../../stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

            if ($this->argument('stack') === 'livewire') {
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/api', resource_path('views/api'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/profile', resource_path('views/profile'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/livewire/resources/views/teams', resource_path('views/teams'));
            } elseif ($this->argument('stack') === 'inertia') {
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/API', resource_path('js/Pages/API'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));
                (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
            }

            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/auth', resource_path('views/auth'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/js', resource_path('js'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/sass', resource_path('sass'));
        }

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {

            (new Filesystem)->delete(resource_path('navigation-dropdown.blade.php'));
            $this->installLivewireStack();

        } elseif ($this->argument('stack') === 'inertia') {

            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Jetstream', resource_path('js/Jetstream'));
            $this->installInertiaStack();
        }
    }

    /**
     * Install the Livewire stack into the application.
     *
     * @return void
     */
    protected function installLivewireStack()
    {
        $this->line('');
        $this->info('Installing livewire stack...');

        if (JetstrapFacade::isBootstrap4()) {
            // NPM Packages...
            Helpers::updateNodePackages(function ($packages) {
                return [
                        "bootstrap" => "^4.5.3",
                        "jquery" => "^3.5.1",
                        "popper.js" => "^1.16.1"
                    ] + $packages;
            });
        } elseif (JetstrapFacade::isBootstrap5()) {
            // NPM Packages...
            Helpers::updateNodePackages(function ($packages) {
                return [
                        "bootstrap" => "^5.0.0-alpha2",
                        "popper.js" => "^1.16.1"
                    ] + $packages;
            });
        }

        // Layouts...This is wrong
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/layouts', resource_path('views/layouts'));

        // Single Blade Views...
        copy(__DIR__.'/../../../stubs/livewire/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Assets...
        (new Filesystem)->copy(__DIR__.'/../../../stubs/resources/js/app.js', resource_path('js/app.js'));

        // Teams...
        if ($this->option('teams')) {
            $this->installLivewireTeamStack();
        }

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->line('');
        $this->info('Bootstrap scaffolding swapped for livewire successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Install the Livewire team stack into the application.
     *
     * @return void
     */
    protected function installLivewireTeamStack()
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/teams'));

        if (JetstrapFacade::bootstrap4()) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/livewire/resources/views/teams', resource_path('views/teams'));
        } elseif (JetstrapFacade::bootstrap5()) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/teams', resource_path('views/teams'));
        }
    }

    /**
     * Install the Inertia stack into the application.
     *
     * @return void
     */
    protected function installInertiaStack()
    {
        $this->line('');
        $this->info('Installing inertia stack...');

        if (JetstrapFacade::bootstrap4()) {
            // Install NPM packages...
            Helpers::updateNodePackages(function ($packages) {
                return [
                        '@inertiajs/inertia' => '^0.3.0',
                        '@inertiajs/inertia-vue' => '^0.2.0',
                        "bootstrap" => "^4.5.3",
                        "jquery" => "^3.5.1",
                        'laravel-jetstream' => '^0.0.3',
                        "popper.js" => "^1.16.1",
                        'portal-vue' => '^2.1.7',
                        'vue' => '^2.5.17',
                        'vue-template-compiler' => '^2.6.10',
                    ] + $packages;
            });
        } elseif (JetstrapFacade::bootstrap5()) {
            // Install NPM packages...
            Helpers::updateNodePackages(function ($packages) {
                return [
                        '@inertiajs/inertia' => '^0.1.7',
                        '@inertiajs/inertia-vue' => '^0.1.2',
                        "bootstrap" => "^5.0.0-alpha2",
                        'laravel-jetstream' => '^0.0.3',
                        "popper.js" => "^1.16.1",
                        'portal-vue' => '^2.1.7',
                        'vue' => '^2.5.17',
                        'vue-template-compiler' => '^2.6.10',
                    ] + $packages;
            });
        }

        // Blade Views...
        copy(__DIR__.'/../../../stubs/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/layouts', resource_path('views/layouts'));

        // Inertia Pages...
        copy(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Dashboard.vue', resource_path('js/Pages/Dashboard.vue'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Layouts', resource_path('js/Layouts'));

        // Assets...
        copy(__DIR__.'/../../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));

        // Teams...
        if ($this->option('teams')) {
            $this->installInertiaTeamStack();
        }

        $this->line('');
        $this->info('Rounding up...');
        $this->installPreset();

        $this->line('');
        $this->info('Bootstrap scaffolding swapped for inertia successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Install the Inertia team stack into the application.
     *
     * @return void
     */
    protected function installInertiaTeamStack()
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Profile'));

        // Pages...
        if (JetstrapFacade::bootstrap4()) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v4/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
        } elseif (JetstrapFacade::bootstrap5()) {
            (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
        }
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
