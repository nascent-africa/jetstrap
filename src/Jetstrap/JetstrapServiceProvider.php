<?php

namespace NascentAfrica\Jetstrap;

use Illuminate\Support\ServiceProvider;

class JetstrapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('jetstrap', function ($app) {
            return new Jetstrap;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureCommands();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (JetstrapFacade::isBootstrap4()) {
            $this->publishes([
                __DIR__.'/../../resources/v4/views' => resource_path('views/vendor/jetstream'),
            ], 'jetstrap-views');
        } elseif (JetstrapFacade::isBootstrap5()) {
            $this->publishes([
                __DIR__.'/../../resources/v5/views' => resource_path('views/vendor/jetstream'),
            ], 'jetstrap-views');
        }
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
            Console\BootstrapFourCommand::class,
            Console\BootstrapFiveCommand::class,
        ]);
    }
}
