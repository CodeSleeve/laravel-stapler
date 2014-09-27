<?php namespace Codesleeve\LaravelStapler;

use Config;
use Illuminate\Support\ServiceProvider;
use Codesleeve\LaravelStapler\Services\ImageRefreshService;
use Codesleeve\Stapler\Stapler;
use Codesleeve\Stapler\Config\IlluminateConfig;

class LaravelStaplerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('codesleeve/laravel-stapler', null, __DIR__);
		$this->bootstrapStapler();
	}

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
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Bootstrap up the stapler package:
	 * - Boot stapler.
	 * - Set the config driver.
	 * - Set public_path config using laravel's public_path() method (if necessary).
	 * - Set base_path config using laravel's base_path() method (if necessary).
	 * 
	 * @return void
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
	 *
	 * @return void
	 */
	protected function registerStaplerFastenCommand()
	{
		$this->app->bind('stapler.fasten', function($app)
		{
			return new Commands\FastenCommand;
		});
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

			return new Commands\RefreshCommand($refreshService);
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
            return new ImageRefreshService();
        });
    }

}
