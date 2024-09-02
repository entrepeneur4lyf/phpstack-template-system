<?php

namespace phpStack\TemplateSystem\Core\Plugins;

/**
 * Interface PluginInterface
 *
 * Defines the contract for plugins in the template system.
 */

/**
 * Interface for plugins in the template system.
 * 
 * This interface defines the methods that all plugins must implement to be
 * compatible with the template system's plugin architecture.
 */
interface PluginInterface
{
    /**
     * Execute the plugin with given arguments and data.
     *
     * @param array<string, mixed> $args An array of arguments passed to the plugin.
     * @param array<string, mixed> $data An array of data available to the plugin.
     * @return mixed The result of the plugin execution.
     */
    public function execute(array $args, array $data);

    /**
     * Get the dependencies of the plugin.
     *
     * @return array<string> An array of plugin names that this plugin depends on.
     */
    public function getDependencies(): array;

    /**
     * Apply the plugin to a component.
     *
     * @param string $name The name of the component.
     * @param array<string, mixed> $options An array of options for applying the plugin.
     * @return string The resulting content after applying the plugin to the component.
     */
    public function applyToComponent(string $name, array $options): string;

    /**
     * Process HTMX content.
     *
     * @param string $content The HTMX content to process.
     * @return string The processed HTMX content.
     */
    public function processHtmxContent(string $content): string;
}
