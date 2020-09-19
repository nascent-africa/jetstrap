<?php

namespace NascentAfrica\Jetstrap\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
    protected $description = 'Swap TailwindCss for Bootstrap.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'jetstrap-views', '--force' => true]);

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {
            $this->installLivewireStack();
        } elseif ($this->argument('stack') === 'inertia') {
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
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    "bootstrap" => "^5.0.0-alpha1",
                    "popper.js" => "^1.16.1"
                ] + $packages;
        });

        // Remove Tailwind Configuration...
        if ((new Filesystem)->exists(base_path('tailwind.config.js'))) {
            (new Filesystem)->delete(base_path('tailwind.config.js'));
        }

        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(public_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/vendor'));

        (new Filesystem)->deleteDirectory(resource_path('css'));

        // Layouts...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/layouts', resource_path('views/layouts'));

        // Single Blade Views...
        copy(__DIR__.'/../../../stubs/livewire/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Other Views...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/api', resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/profile', resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/vendor', resource_path('views/vendor'));

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
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/livewire/resources/views/teams', resource_path('views/teams'));
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

        // Remove Tailwind Configuration...
        if ((new Filesystem)->exists(base_path('tailwind.config.js'))) {
            (new Filesystem)->delete(base_path('tailwind.config.js'));
        }

        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        // Directories...
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(public_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Jetstream'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Mixins'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/API'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/Profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));

        if ((new Filesystem)->exists(resource_path('css'))) {
            (new Filesystem)->deleteDirectory(resource_path('css'));
        }

        // Blade Views...
        copy(__DIR__.'/../../../stubs/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views/layouts', resource_path('views/layouts'));

        // Inertia Pages...
        copy(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Dashboard.vue', resource_path('js/Pages/Dashboard.vue'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Jetstream', resource_path('js/Jetstream'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Mixins', resource_path('js/Mixins'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/API', resource_path('js/Pages/API'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Profile', resource_path('js/Pages/Profile'));

        // Assets...
        $this->publishBootstrapAssets();
        copy(__DIR__.'/../../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));

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
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/Teams', resource_path('js/Pages/Teams'));
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param string $search
     * @param string $replace
     * @param string $path
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * @return void
     */
    public function publishBootstrapAssets()
    {
        // Change the welcome view...
        copy(__DIR__.'/../../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        copy(__DIR__.'/../../../stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../../stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/sass', resource_path('sass'));
        copy(__DIR__.'/../../../stubs/public/css/app.css', public_path('css/app.css'));
    }
}
