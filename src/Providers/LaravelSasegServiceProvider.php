<?php

namespace Rodsaseg\LaravelSaseg\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

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

    public function boot(Filesystem $filesystem)
    {
        $this->publishes([
            __DIR__.'/../Database/Migrations/update_roles_table_add_deletable.php.stub' => $this->getMigrationFileName($filesystem),
        ], 'migrations');
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

        //Publis Permission Key
        $this->publishes([
            __DIR__.'/../Providers/Publish' => base_path('app/Providers'),
        ], 'laravelsaseg');
    }

     /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_update_roles_table_add_deletable.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_update_roles_table_add_deletable.php")
            ->first();
    }
}