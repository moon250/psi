<?php

namespace App\Providers;

use Barryvdh\Debugbar\DataCollector\FilesCollector;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Debugbar::disable();
        Debugbar::addCollector(new FilesCollector);

        Vite::useScriptTagAttributes([
            'defer' => true,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
