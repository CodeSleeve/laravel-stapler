<?php

namespace Codesleeve\LaravelStapler;

use Codesleeve\Stapler\Interfaces\Config;
use Illuminate\Config\Repository;

class IlluminateConfig implements Config
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
     * The separator between package name and item.
     *
     * @var string
     */
    protected $separator;

    /**
     * Constructor method.
     *
     * @param Repository $config
     * @param string     $packageName
     * @param string     $separator
     */
    public function __construct(Repository $config, $packageName = null, $separator = '::')
    {
        $this->config = $config;
        $this->packageName = $packageName;
        $this->separator = $separator;
    }

    /**
     * Retrieve a configuration value.
     *
     * @param $name
     *
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
     *
     * @return mixed
     */
    public function set($name, $value)
    {
        $item = $this->getItemPath($name);

        return $this->config->set($item, $value);
    }

    /**
     * Return the path to an item so that it can be loaded via config.
     * We need to append the package name to the item separated
     * with '::' for L4 and '.' for L5.
     * 
     * @param string $item
     *
     * @return string
     */
    protected function getItemPath($item)
    {
        return $this->packageName.$this->separator.$item;
    }
}
