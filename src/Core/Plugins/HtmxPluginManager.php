<?php

namespace phpStack\TemplateSystem\Core\Plugins;

/**
 * HtmxPluginManager class for managing HTMX-specific plugins.
 * This class extends the base PluginManager to provide HTMX-specific functionality.
 */
class HtmxPluginManager extends PluginManager
{
    /**
     * Register an HTMX-specific plugin.
     *
     * @param string $name The name of the plugin.
     * @param HtmxPluginInterface $plugin The plugin instance.
     * @param string $version The version of the plugin.
     */
    public function registerHtmxPlugin(string $name, HtmxPluginInterface $plugin, string $version): void
    {
        parent::registerPlugin($name, $plugin, $version);
    }

    /**
     * Apply all registered HTMX plugins to the given content.
     *
     * @param string $content The content to process.
     * @return string The processed content after applying all HTMX plugins.
     */
    public function applyHtmxPlugins(string $content): string
    {
        foreach ($this->getAll() as $plugin) {
            if ($plugin instanceof HtmxPluginInterface) {
                $content = $plugin->processHtmxContent($content);
            }
        }
        return $content;
    }
}