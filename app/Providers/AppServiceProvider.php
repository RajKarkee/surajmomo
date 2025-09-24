<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom artisan commands (useful for temporary diagnostics)
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\SendTestEmail::class,
            ]);
        }
    }
}
