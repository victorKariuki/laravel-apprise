<?php

namespace BrevaimLabs\LaravelApprise;

use Illuminate\Support\ServiceProvider;

class AppriseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register the Apprise service as a singleton
        $this->app->singleton(Apprise::class, function ($app) {
            return new Apprise(config('apprise.command'));
        });
    }

    public function boot(): void
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/config/apprise.php' => config_path('apprise.php'),
        ]);
    }
}
