<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class LazyLoadedComponent
 *
 * Represents a component that is loaded lazily.
 */
class LazyLoadedComponent
{
    /** @var callable */
    private $loader;

    /** @var mixed */
    private $component;

    public function __construct(callable $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @return mixed
     */
    public function load()
    {
        if ($this->component === null) {
            $this->component = ($this->loader)();
        }
        return $this->component;
    }
}
