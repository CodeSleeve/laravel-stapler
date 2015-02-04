<?php namespace Codesleeve\LaravelStapler\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Codesleeve\LaravelStapler\Commands\RefreshCommand;
use Codesleeve\LaravelStapler\Services\ImageRefreshService;

abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap up the stapler package:
     * - Boot stapler.
     * - Set the config driver.
     * - Set public_path config using laravel's public_path() method (if necessary).
     * - Set base_path config using laravel's base_path() method (if necessary).
     * 
     * @return void
     */
    abstract protected function bootstrapStapler();

    /**
     * Register the stapler fasten command with the container.
     *
     * @return void
     */
    abstract protected function registerStaplerFastenCommand();

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // commands
        $this->registerStaplerFastenCommand();
        $this->registerStaplerRefreshCommand();

        // services
        $this->registerImageRefreshService();

        $this->commands('stapler.fasten');
        $this->commands('stapler.refresh');
    }

    /**
     * Register the stapler refresh command with the container.
     *
     * @return void
     */
    protected function registerStaplerRefreshCommand()
    {
        $this->app->bind('stapler.refresh', function($app)
        {
            $refreshService = $app['ImageRefreshService'];

            return new RefreshCommand($refreshService);
        });
    }

    /**
     * Register the image refresh service with the container.
     * 
     * @return void 
     */
    protected function registerImageRefreshService()
    {
        $this->app->singleton('ImageRefreshService', function($app, $params) {
            return new ImageRefreshService($app);
        });
    }
}