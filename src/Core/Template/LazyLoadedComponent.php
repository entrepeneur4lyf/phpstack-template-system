<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class LazyLoadedComponent
 *
 * Represents a component that is loaded lazily.
 */
class LazyLoadedComponent
{
    /**
     * @var callable A callable responsible for loading the component.
     */
    private $loader;

    /**
     * @var mixed The loaded component instance.
     */
    private $component;

    /**
     * LazyLoadedComponent constructor.
     *
     * @param callable $loader A callable that loads the component.
     */
    public function __construct(callable $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Loads the component if it hasn't been loaded yet.
     *
     * Loads the component if it hasn't been loaded yet.
     *
     * @return mixed The loaded component instance.
     */
    public function load()
    {
        if ($this->component === null) {
            $this->component = ($this->loader)();
        }
        return $this->component;
    }
}
