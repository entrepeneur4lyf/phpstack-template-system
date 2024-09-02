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
     * Executes the plugin with the given arguments and data.
     *
     * @param array<string, mixed> $args The arguments for the plugin.
     * @param array<string, mixed> $data The data to be used by the plugin.
     * @return mixed The result of the plugin execution.
     */
    public function execute(array $args, array $data);

    /**
     * Returns the dependencies required by the plugin.
     *
     * @return array<string> An array of dependency names.
     */
    public function getDependencies(): array;

    /**
     * Applies the plugin to a component with the given name and options.
     *
     * @param string $name The name of the component.
     * @param array<string, mixed> $options The options for the component.
     * @return string The modified component as a string.
     */
    public function applyToComponent(string $name, array $options): string;
}
