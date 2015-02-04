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
     * The string separator used when loading configuration items.
     * 
     * @var string
     */
    protected $separator;

    /**
     * Constructor method.
     *
     * @param Repository $config
     * @param string $packageName
     */
    function __construct(Repository $config, $packageName, $separator = '::')
    {
        $this->config = $config;
        $this->packageName = $packageName;
        $this->separator = $separator;
    }

    /**
     * Retrieve a configuration value.
     *
     * @param $name
     * @return mixed
     */
    public function get($name) 
    {
        $item = $this->packageName . $this->separator . $name;

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
        $item = $this->packageName . $this->separator . $name;

        return $this->config->set($item, $value);
    }
}