<?php

namespace Mischa\Vpicnhtsa;

use Mischa\Vpicnhtsa\Actions\SearchNumber;
use Mischa\Vpicnhtsa\Actions\SearchVin;
use Illuminate\Support\ServiceProvider;
use Lorisleiva\Actions\Facades\Actions;

class VpicnhtsaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SearchVin::class,
                SearchNumber::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('vpicnhtsa', function () {
            return new Vpicnhtsa;
        });
    }
}
