<?php

namespace NascentAfrica\Jetstrap\Console;

use NascentAfrica\Jetstrap\JetstrapFacade as Jetstrap;

class InstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jetstrap:swap {stack : The development stack that should be installed}
                                              {--teams : Indicates if team support should be installed}';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (Jetstrap::isBootstrap4()) {
            $this->call('jetstrap:swap:bootstrap-4', [
                'stack' => $this->argument('stack'),
                '--teams' => $this->option('teams')
            ]);
        } elseif (Jetstrap::isBootstrap5()) {
            $this->call('jetstrap:swap:bootstrap-5', [
                'stack' => $this->argument('stack'),
                '--teams' => $this->option('teams')
            ]);
        }
    }
}
