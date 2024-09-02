<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Interface PluginInterface
 *
 * Defines the contract for plugins in the template system.
 */
interface PluginInterface
{
    /**
     * @param array $args
     * @param array $data
     * @return mixed
     */
    public function execute(array $args, array $data);

    /**
     * @return array<string>
     */
    public function getDependencies(): array;

    /**
     * @param string $name
     * @param array<string, mixed> $options
     * @return string
     */
    public function applyToComponent(string $name, array $options): string;
}
