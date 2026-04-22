<?php

namespace App\Providers;

use Illuminate\Foundation\Vite;
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
        // In production, ignore accidental public/hot leftovers from dev servers.
        if ($this->app->environment('production')) {
            app(Vite::class)->useHotFile(storage_path('framework/vite.hot'));
        }
    }
}
