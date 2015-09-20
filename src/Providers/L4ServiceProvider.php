<?php

namespace Codesleeve\LaravelStapler\Providers;

use Codesleeve\LaravelStapler\IlluminateConfig;
use Codesleeve\Stapler\Stapler;
use Codesleeve\LaravelStapler\Commands\FastenCommand;
use Config;

class L4ServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->package('codesleeve/laravel-stapler', null, dirname(__DIR__));
        $this->bootstrapStapler();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Bootstrap up the stapler package:
     * - Boot stapler.
     * - Set the config driver.
     * - Set public_path config using laravel's public_path() method (if necessary).
     * - Set base_path config using laravel's base_path() method (if necessary).
     */
    protected function bootstrapStapler()
    {
        Stapler::boot();

        $config = new IlluminateConfig(Config::getFacadeRoot(), 'laravel-stapler');
        Stapler::setConfigInstance($config);

        if (!$config->get('stapler.public_path')) {
            $config->set('stapler.public_path', realpath(public_path()));
        }

        if (!$config->get('stapler.base_path')) {
            $config->set('stapler.base_path', realpath(base_path()));
        }
    }

    /**
     * Register the stapler fasten command with the container.
     */
    protected function registerStaplerFastenCommand()
    {
        $this->app->bind('stapler.fasten', function ($app) {
            $migrationsFolderPath = app_path().'/database/migrations';

            return new FastenCommand($app['view'], $app['files'], $migrationsFolderPath);
        });
    }

    /**
     * Register the the migrations folder path with the container.
     */
    protected function registerMigrationFolderPath()
    {
        $this->app->bind('migration_folder_path', app_path().'/database/migrations');
    }
}
