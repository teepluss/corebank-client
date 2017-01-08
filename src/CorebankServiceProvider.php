<?php

namespace App\Support\Corebank;

use Illuminate\Support\ServiceProvider;

class CorebankServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config.
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('corebank.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('corebank.client', function ($app) {
            return new Corebank($app['config']['corebank']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'corebank.client',
        ];
    }
}
