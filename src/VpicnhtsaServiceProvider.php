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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'vpicnhtsa');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');


        Actions::registerRoutesForAction(SearchVin::class);
        Actions::registerRoutesForAction(SearchNumber::class);

//        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

//        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vpicnhtsa');

        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__.'/../config/config.php' => config_path('vpicnhtsa.php'),
//            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/vpicnhtsa'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/vpicnhtsa'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/vpicnhtsa'),
            ], 'lang');*/

            // Registering package commands.
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
//        // Automatically apply the package configuration
//        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'vpicnhtsa');

        // Register the main class to use with the facade
        $this->app->singleton('vpicnhtsa', function () {
            return new Vpicnhtsa;
        });
    }
}
