<?php

namespace phpStack\TemplateSystem\Core\Template {
    /**
     * Main class for rendering templates and managing components.
     */
    class TemplateEngine {
        /**
         * Constructor for TemplateEngine.
         * 
         * @param string $templateDir Directory containing template files
         * @param PerformanceProfiler $profiler Performance profiler instance
         * @param \Psr\Cache\CacheItemPoolInterface $cache PSR-6 compatible cache implementation
         */
        public function __construct(string $templateDir, PerformanceProfiler $profiler, \Psr\Cache\CacheItemPoolInterface $cache) {}

        /**
         * Render a template with the given data.
         * 
         * @param string $template Name of the template file
         * @param array $data Data to be passed to the template
         * @return string Rendered template content
         */
        public function render(string $template, array $data = []): string {}

        /**
         * Register a component for use in templates.
         * 
         * @param string $name Name of the component
         * @param callable $component Component rendering function
         * @param string|null $style CSS styles for the component
         * @param string|null $script JavaScript for the component
         * @param array $events Event handlers for the component
         * @param array $dependencies Dependencies of the component
         */
        public function registerComponent(string $name, callable $component, string $style = null, string $script = null, array $events = [], array $dependencies = []): void {}

        /**
         * Get the ComponentPlugin instance.
         * 
         * @return ComponentPlugin
         */
        public function getComponentPlugin(): ComponentPlugin {}
    }

    /**
     * Class for managing HTMX-specific components and functionality.
     */
    class HtmxComponents {
        /**
         * Register all HTMX components with the TemplateEngine.
         * 
         * @param TemplateEngine $engine TemplateEngine instance
         * @param HtmxConfig|null $config HTMX configuration
         */
        public static function registerAll(TemplateEngine $engine, HtmxConfig $config = null) {}

        /**
         * Register a plugin with the HTMX system.
         * 
         * @param string $name Name of the plugin
         * @param mixed $plugin Plugin instance or callable
         * @param string $version Version of the plugin
         */
        public static function registerPlugin(string $name, $plugin, string $version) {}
    }

    /**
     * Configuration class for HTMX.
     */
    class HtmxConfig {
        /**
         * Constructor for HtmxConfig.
         * 
         * @param array $config Configuration options
         */
        public function __construct(array $config = []) {}

        /**
         * Get a configuration value.
         * 
         * @param string $key Configuration key
         * @param mixed $default Default value if key doesn't exist
         * @return mixed Configuration value
         */
        public function get($key, $default = null) {}

        /**
         * Set a configuration value.
         * 
         * @param string $key Configuration key
         * @param mixed $value Configuration value
         */
        public function set($key, $value): void {}
    }

    /**
     * Performance profiling class.
     */
    class PerformanceProfiler {
        /**
         * Start profiling for a given name.
         * 
         * @param string $name Name of the profile
         */
        public function startProfile(string $name): void {}

        /**
         * End profiling for a given name.
         * 
         * @param string $name Name of the profile
         */
        public function endProfile(string $name): void {}

        /**
         * Get all profiles.
         * 
         * @return array Array of profile durations
         */
        public function getAllProfiles(): array {}
    }
}

namespace phpStack\TemplateSystem\Core\Template\Plugins {
    /**
     * Plugin for managing components.
     */
    class ComponentPlugin {
        /**
         * Execute a component.
         * 
         * @param array $args Arguments for the component
         * @param array $data Data for the component
         * @return mixed Result of component execution
         */
        public function execute(array $args, array $data) {}

        /**
         * Register a component.
         * 
         * @param string $name Name of the component
         * @param mixed $component Component instance or callable
         * @param string|null $style CSS styles for the component
         * @param string|null $script JavaScript for the component
         * @param array $events Event handlers for the component
         * @param array $dependencies Dependencies of the component
         */
        public function register(string $name, $component, string $style = null, string $script = null, array $events = [], array $dependencies = []): void {}
    }
}

namespace phpStack\TemplateSystem\Core\Plugins {
    /**
     * Manager class for plugins.
     */
    class PluginManager {
        /**
         * Register a plugin.
         * 
         * @param string $name Name of the plugin
         * @param mixed $plugin Plugin instance
         * @param string $version Version of the plugin
         */
        public function registerPlugin(string $name, $plugin, string $version): void {}

        /**
         * Get a plugin by name.
         * 
         * @param string $name Name of the plugin
         * @return mixed|null Plugin instance or null if not found
         */
        public function getPlugin(string $name) {}

        /**
         * Check if a plugin exists.
         * 
         * @param string $name Name of the plugin
         * @return bool True if the plugin exists, false otherwise
         */
        public function hasPlugin(string $name): bool {}

        /**
         * Update a plugin.
         * 
         * @param string $name Name of the plugin
         * @param mixed $newPlugin New plugin instance
         * @param string $newVersion New version of the plugin
         */
        public function updatePlugin(string $name, $newPlugin, string $newVersion): void {}

        /**
         * Get all plugins.
         * 
         * @return array Array of all registered plugins
         */
        public function getAll(): array {}

        /**
         * Resolve conflicts between plugins.
         * 
         * @param array $conflictingPlugins Array of conflicting plugin configurations
         */
        public function resolveConflicts(array $conflictingPlugins): void {}
    }
}

namespace phpStack\TemplateSystem\Core\Template {
    /**
     * Interface for plugins.
     */
    interface PluginInterface {
        /**
         * Execute the plugin.
         * 
         * @param array $args Arguments for the plugin
         * @param array $data Data for the plugin
         * @return mixed Result of plugin execution
         */
        public function execute(array $args, array $data);

        /**
         * Get dependencies of the plugin.
         * 
         * @return array Array of plugin dependencies
         */
        public function getDependencies(): array;
    }
}