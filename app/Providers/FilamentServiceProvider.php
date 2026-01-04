<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Filament;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Filament::serving(function () {
            Filament::registerRenderHook(
                'global',
                fn () => view()->share('breadcrumbs', null)
            );
        });

    }
}
