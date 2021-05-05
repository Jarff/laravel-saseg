<?php

namespace Rodsaseg\LaravelSaseg\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelSasegServiceProvider extends ServiceProvider
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

        //Default Controllers
        $this->publishes([
            __DIR__.'/../Controllers' => base_path('app/Http/Controllers'),
        ], 'laravelsaseg');


        //Default DataTables
        $this->publishes([
            __DIR__.'/../DataTables' => base_path('app/DataTables'),
        ], 'laravelsaseg');

        //Scripts (needs webpack)
        $this->publishes([
            __DIR__.'/../resources' => base_path('resources/js/vendor/panel'),
        ], 'laravelsaseg');

        //Publish seeders
        $this->publishes([
            __DIR__.'/../Database/Seeds' => base_path('database/seeds'),
        ], 'laravelsaseg');

        $this->publishes([
            __DIR__.'/../Database/Migrations/update_roles_table_add_deletable.php.stub' => $this->getMigrationFileName($filesystem),
        ], 'migrations');

        // //Publish migrations
        // $this->publishes([
        //     __DIR__.'/../Database/Migrations' => base_path('database/migrations'),
        // ], 'laravelsaseg');

        //Publis Permission Key
        $this->publishes([
            __DIR__.'/../Providers/Publish' => base_path('app/Providers'),
        ], 'laravelsaseg');
    }
}