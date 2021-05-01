<?php

namespace Saseg\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class SasegServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    public function boot(Router $router)
    {
        //TODO: Verify installation
        // $router->middlewareGroup('install', [CanInstall::class]);
        // $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        //Publish the assets
        $this->publishes([
            __DIR__.'/../assets' => base_path('public/panel/assets'),
        ], 'laravelsaseg');

        //Default Views
        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/vendor/panel'),
        ], 'laravelsaseg');

        //Scripts (needs webpack)
        $this->publishes([
            __DIR__.'/../resources' => base_path('resources/js/vendor/panel'),
        ], 'laravelsaseg');

        //Publish seeders
        $this->publishes([
            __DIR__.'/../Database/Seeds' => base_path('database/seeds'),
        ], 'laravelsaseg');

        //Updates middleware
        $this->publishes([
            __DIR__.'/../Middleware/Authenticate.php' => base_path('app/Http/Middleware'),
        ], 'laravelsaseg');
    }
}