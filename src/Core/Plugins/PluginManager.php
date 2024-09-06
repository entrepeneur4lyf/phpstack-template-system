<?php

declare(strict_types=1);

namespace phpStack\Core\Plugins;

use RuntimeException;
use phpStack\Core\Template\PluginInterface;
use phpStack\Core\Exceptions\PluginConflictException;
use phpStack\Core\Template\Plugins\ComponentPlugin;
use phpStack\Core\Template\Plugins\FilterPlugin;
use phpStack\Core\Template\Plugins\ForeachPlugin;
use phpStack\Core\Template\Plugins\ForPlugin;
use phpStack\Core\Template\Plugins\IfPlugin;
use phpStack\Core\Template\Plugins\IncludePlugin;
use phpStack\Core\Template\Plugins\MatchPlugin;
use phpStack\Core\Template\Plugins\RenderPlugin;
use phpStack\Core\Template\Plugins\SortPlugin;
use phpStack\Core\Template\Plugins\SwitchPlugin;
use phpStack\Core\Template\Plugins\WhilePlugin;
use phpStack\Core\Template\TemplateEngine;

interface HtmxPluginInterface extends PluginInterface
{
    public function processHtmxContent(string $content): string;
}

/**
 * PluginManager class for managing plugins in the template system.
 *
 * This class handles plugin registration, dependency management, conflict resolution,
 * and execution of plugin hooks.
 */
class PluginManager
{
    /** @var array<string, array{plugin: PluginInterface|callable, enabled: bool}> */
    private array $plugins = [];
    /** @var array<string, array<string>> */
    private array $dependencies = [];
    /** @var array<string, array<string, callable>> */
    private array $hooks = [];
    /** @var array<string> */
    private array $loadOrder = [];
    private TemplateEngine $templateEngine;
    private string $templateDir;

    public function __construct(TemplateEngine $templateEngine, string $templateDir)
    {
        $this->templateEngine = $templateEngine;
        $this->templateDir = $templateDir;
        $this->registerDefaultPlugins();
    }

    private function registerDefaultPlugins(): void
    {
        // Note: ComponentPlugin instantiation is commented out as it requires parameters we don't have
        // $this->registerPlugin('component', new ComponentPlugin(...));
        $this->registerPlugin('filter', new FilterPlugin());
        $this->registerPlugin('foreach', new ForeachPlugin());
        $this->registerPlugin('for', new ForPlugin($this->templateEngine));
        $this->registerPlugin('if', new IfPlugin($this->templateEngine));
        $this->registerPlugin('include', new IncludePlugin($this->templateDir));
        $this->registerPlugin('match', new MatchPlugin());
        $this->registerPlugin('render', new RenderPlugin($this->templateEngine));
        $this->registerPlugin('sort', new SortPlugin());
        $this->registerPlugin('switch', new SwitchPlugin());
        $this->registerPlugin('while', new WhilePlugin());
    }

    /**
     * Register a new plugin.
     *
     * @param string $name The name of the plugin.
     * @param PluginInterface|callable $plugin The plugin instance or callable.
     * @param array<string> $dependencies An array of plugin names that this plugin depends on.
     */
    public function registerPlugin(string $name, PluginInterface|callable $plugin, array $dependencies = []): void
    {
        $this->plugins[$name] = ['plugin' => $plugin, 'enabled' => true];
        $this->dependencies[$name] = $dependencies;
        $this->loadOrder[] = $name;

        if ($plugin instanceof PluginInterface && method_exists($plugin, 'getHooks')) {
            $this->registerHooks($name, $plugin->getHooks());
        }
    }

    /**
     * Register hooks for a plugin.
     *
     * @param string $pluginName The name of the plugin.
     * @param array<string, callable> $hooks An array of hook names and their corresponding callbacks.
     */
    private function registerHooks(string $pluginName, array $hooks): void
    {
        foreach ($hooks as $hookName => $callback) {
            if (!isset($this->hooks[$hookName])) {
                $this->hooks[$hookName] = [];
            }
            $this->hooks[$hookName][$pluginName] = $callback;
        }
    }

    /**
     * Get all registered plugins.
     *
     * @return array<string, array{plugin: PluginInterface|callable, enabled: bool}>
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * Get all plugin dependencies.
     *
     * @return array<string, array<string>>
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * Get all registered hooks.
     *
     * @return array<string, array<string, callable>>
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * Get the load order of plugins.
     *
     * @return array<string>
     */
    public function getLoadOrder(): array
    {
        return $this->loadOrder;
    }

    /**
     * Enable a plugin.
     *
     * @param string $name The name of the plugin to enable.
     * @throws RuntimeException If the plugin is not registered.
     */
    public function enablePlugin(string $name): void
    {
        if (!isset($this->plugins[$name])) {
            throw new RuntimeException("Plugin '$name' is not registered.");
        }
        $this->plugins[$name]['enabled'] = true;
    }

    /**
     * Disable a plugin.
     *
     * @param string $name The name of the plugin to disable.
     * @throws RuntimeException If the plugin is not registered.
     */
    public function disablePlugin(string $name): void
    {
        if (!isset($this->plugins[$name])) {
            throw new RuntimeException("Plugin '$name' is not registered.");
        }
        $this->plugins[$name]['enabled'] = false;
    }

    /**
     * Check if a plugin is enabled.
     *
     * @param string $name The name of the plugin to check.
     * @return bool True if the plugin is enabled, false otherwise.
     * @throws RuntimeException If the plugin is not registered.
     */
    public function isPluginEnabled(string $name): bool
    {
        if (!isset($this->plugins[$name])) {
            throw new RuntimeException("Plugin '$name' is not registered.");
        }
        return $this->plugins[$name]['enabled'];
    }

    /**
     * Execute a hook for all enabled plugins that have registered it.
     *
     * @param string $hookName The name of the hook to execute.
     * @param mixed $args The arguments to pass to the hook callbacks.
     * @return array<mixed> An array of results from the hook callbacks.
     */
    public function executeHook(string $hookName, mixed $args): array
    {
        $results = [];
        if (isset($this->hooks[$hookName])) {
            foreach ($this->hooks[$hookName] as $pluginName => $callback) {
                if ($this->isPluginEnabled($pluginName)) {
                    $results[$pluginName] = $callback($args);
                }
            }
        }
        return $results;
    }

    /**
     * Resolve plugin conflicts based on their dependencies and load order.
     *
     * @throws PluginConflictException If there are circular dependencies or unresolvable conflicts.
     */
    public function resolveConflicts(): void
    {
        $resolved = [];
        $unresolved = [];

        foreach ($this->loadOrder as $pluginName) {
            $this->depthFirstSearch($pluginName, $resolved, $unresolved);
        }

        $this->loadOrder = array_values(array_unique($resolved));
    }

    /**
     * Perform a depth-first search to resolve plugin dependencies.
     *
     * @param string $pluginName The name of the plugin to resolve.
     * @param array<string> $resolved Array of resolved plugin names.
     * @param array<string> $unresolved Array of unresolved plugin names.
     * @throws PluginConflictException If there are circular dependencies.
     */
    private function depthFirstSearch(string $pluginName, array &$resolved, array &$unresolved): void
    {
        $unresolved[] = $pluginName;

        if (isset($this->dependencies[$pluginName])) {
            foreach ($this->dependencies[$pluginName] as $dependencyName) {
                if (!in_array($dependencyName, $resolved)) {
                    if (in_array($dependencyName, $unresolved)) {
                        throw new PluginConflictException("Circular dependency detected: $pluginName <- $dependencyName");
                    }
                    $this->depthFirstSearch($dependencyName, $resolved, $unresolved);
                }
            }
        }

        $resolved[] = $pluginName;
        array_pop($unresolved);
    }
}
