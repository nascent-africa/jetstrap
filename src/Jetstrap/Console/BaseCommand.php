<?php

namespace NascentAfrica\Jetstrap\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use NascentAfrica\Jetstrap\CoreUi;
use NascentAfrica\Jetstrap\JetstrapFacade;

abstract class BaseCommand extends Command
{
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

        // Remove Tailwind Configuration...
        if ((new Filesystem)->exists(base_path('tailwind.config.js'))) {
            (new Filesystem)->delete(base_path('tailwind.config.js'));
        }

        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->ensureDirectoryExists(public_path('css'));

        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        (new Filesystem)->deleteDirectory(resource_path('css'));

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {
            (new Filesystem)->delete(resource_path('navigation-dropdown.blade.php'));

            $this->installLivewireStack();
        } elseif ($this->argument('stack') === 'inertia') {
            $this->installInertiaStack();
        }
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
     *
     */
    protected function installPreset()
    {
        // Check for preset usage...
        if ($preset = JetstrapFacade::getPreset()) {
            switch ($preset) {
                case 'core-ui-3':
                    $this->line('');
                    $this->info('Setting up Core Ui 3.');
                    CoreUi::setupCoreUi3($this->argument('stack'));
                    break;
            }
        }
    }
}
