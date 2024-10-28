<?php

namespace BrevaimLabs\LaravelApprise;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppriseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Check if Apprise is installed
        if (!$this->isAppriseInstalled()) {
            Log::error('Apprise is not installed. Please install it via PyPI or your package manager.');
            throw new \RuntimeException('Apprise is not installed. Please install it via PyPI or your package manager.');
        }

        // Register the Apprise service as a singleton
        $this->app->singleton(Apprise::class, function ($app) {
            return new Apprise(config('apprise.command'));
        });
    }

    public function boot(): void
    {
        // No configuration files to publish
    }

    private function isAppriseInstalled(): bool
    {
        // Attempt to run the 'apprise' command to check installation
        $output = null;
        $returnVar = null;

        // Execute a command to check if Apprise is available
        exec('apprise --version', $output, $returnVar);

        // Return true if the command succeeded
        return $returnVar === 0;
    }
}
