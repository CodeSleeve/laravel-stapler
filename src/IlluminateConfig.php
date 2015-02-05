<?php namespace Codesleeve\LaravelStapler;

use Codesleeve\Stapler\Config\ConfigurableInterface;
use Illuminate\Config\Repository;

class IlluminateConfig implements ConfigurableInterface
{
    /**
     * An instance of Laravel's config class.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The name of the package this driver is being used with.
     * 
     * @var string
     */
    protected $packageName;

    /**
     * Constructor method.
     *
     * @param Repository $config
     * @param string $packageName
     */
    function __construct(Repository $config, $packageName = null)
    {
        $this->config = $config;
        $this->packageName = $packageName;
    }

    /**
     * Retrieve a configuration value.
     *
     * @param $name
     * @return mixed
     */
    public function get($name) 
    {
        $item = $this->getItemPath($name);

        return $this->config->get($item);
    }

    /**
     * Set a configuration value.
     *
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value) 
    {
        $item = $this->getItemPath($name);

        return $this->config->set($item, $value);
    }

    /**
     * Return the path to an item so that it can be loaded via config.
     * For L4, we need to append the package name to the item separated
     * with '::'.  For L5 this is no longer necessary.
     * 
     * @param  string $item
     * @return string
     */
    protected function getItemPath($item)
    {
        if ($this->packageName) {
            return $this->packageName . '::' . $item;
        }

        return $item;
    }
}