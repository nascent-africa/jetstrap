<?php

namespace NascentAfrica\Jetstrap\Console;

use Illuminate\Filesystem\Filesystem;

class BootstrapFiveCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jetstrap:swap:bootstrap-5 {stack : The development stack that should be installed}
                                              {--teams : Indicates if team support should be installed}';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Install the Livewire stack into the application.
     *
     * @return void
     */
    protected function installLivewireStack()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    "bootstrap" => "^5.0.0-alpha1",
                    "popper.js" => "^1.16.1"
                ] + $packages;
        });

        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/vendor'));

        // Layouts...This is wrong
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/livewire/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/resources/views/layouts', resource_path('views/layouts'));

        // Single Blade Views...
        copy(__DIR__.'/../../../stubs/v5/livewire/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Other Views...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/livewire/resources/views/api', resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/livewire/resources/views/profile', resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/livewire/resources/views/vendor', resource_path('views/vendor'));

        // Assets...
        $this->publishBootstrapAssets();

        // Teams...
        if ($this->option('teams')) {
            $this->installLivewireTeamStack();
        }

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

        // Other Views...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/livewire/resources/views/teams', resource_path('views/teams'));
    }

    /**
     * Install the Inertia stack into the application.
     *
     * @return void
     */
    protected function installInertiaStack()
    {
        // Install NPM packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    '@inertiajs/inertia' => '^0.1.7',
                    '@inertiajs/inertia-vue' => '^0.1.2',
                    "bootstrap" => "^5.0.0-alpha1",
                    'laravel-jetstream' => '^0.0.3',
                    "popper.js" => "^1.16.1",
                    'portal-vue' => '^2.1.7',
                    'vue' => '^2.5.17',
                    'vue-template-compiler' => '^2.6.10',
                ] + $packages;
        });

        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Jetstream'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/API'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));

        // Blade Views...
        copy(__DIR__.'/../../../stubs/v5/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/resources/views/layouts', resource_path('views/layouts'));

        // Inertia Pages...
        copy(__DIR__.'/../../../stubs/v5/inertia/resources/js/Pages/Dashboard.vue', resource_path('js/Pages/Dashboard.vue'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/inertia/resources/js/Jetstream', resource_path('js/Jetstream'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/inertia/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/inertia/resources/js/Pages/API', resource_path('js/Pages/API'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));

        // Assets...
        $this->publishBootstrapAssets();
        copy(__DIR__.'/../../../stubs/v5/inertia/resources/js/app.js', resource_path('js/app.js'));

        // Teams...
        if ($this->option('teams')) {
            $this->installInertiaTeamStack();
        }

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
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
    }

    /**
     * @return void
     */
    public function publishBootstrapAssets()
    {
        // Change the welcome view...
        copy(__DIR__.'/../../../stubs/v5/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        (new Filesystem)->copy(__DIR__.'/../../../stubs/v5/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../../stubs/v5/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/v5/resources/sass', resource_path('sass'));
    }
}
