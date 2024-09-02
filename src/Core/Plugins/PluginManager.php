<?php

declare(strict_types=1);

namespace phpStack\TemplateSystem\Core\Plugins;

use RuntimeException;
use phpStack\TemplateSystem\Core\Template\PluginInterface;
use phpStack\TemplateSystem\Core\Exceptions\PluginConflictException;

/**
 * PluginManager class for managing plugins in the template system.
 *
 * This class handles plugin registration, dependency management, conflict resolution,
 * and execution of plugin hooks.
 */
class PluginManager
{
    /** @var array<string, array{plugin: PluginInterface|callable, version: string, enabled: bool}> */
    private array $plugins = [];
    private array $versions = [];
    private array $dependencies = [];
    private array $hooks = [];
    /** @var array<string> */
    private array $loadOrder = [];

    public function __construct()
    {
        $this->registerDefaultPlugins();
    }

    private function registerDefaultPlugins(): void
    {
        $this->registerPlugin('if', new IfPlugin(), '1.0.0');
        $this->registerPlugin('switch', new SwitchPlugin(), '1.0.0');
        $this->registerPlugin('while', new WhilePlugin(), '1.0.0');
        $this->registerPlugin('for', new ForPlugin(), '1.0.0');
        $this->registerPlugin('foreach', new ForeachPlugin(), '1.0.0');
        $this->registerPlugin('match', new MatchPlugin(), '1.0.0');
    }

    /**
     * Register a new plugin.
     *
     * @param string $name The name of the plugin.
     * @param PluginInterface|callable $plugin The plugin instance or callable.
     * @param string $version The version of the plugin.
     * @param array $dependencies An array of plugin names that this plugin depends on.
     */
    public function registerPlugin(string $name, PluginInterface|callable $plugin, string $version, array $dependencies = []): void
    {
        $this->plugins[$name] = ['plugin' => $plugin, 'version' => $version, 'enabled' => true];
        $this->versions[$name] = $version;
        $this->dependencies[$name] = $dependencies;
        $this->loadOrder[] = $name;

        if ($plugin instanceof PluginInterface && method_exists($plugin, 'getHooks')) {
            $this->registerHooks($name, $plugin->getHooks());
        }
    }

    /**
     * Get a plugin by name.
     *
     * @param string $name The name of the plugin.
     * @return PluginInterface|null The plugin instance if found, null otherwise.
     */
    public function getPlugin(string $name): ?PluginInterface
    {
        return $this->plugins[$name]['plugin'] instanceof PluginInterface ? $this->plugins[$name]['plugin'] : null;
    }

    /**
     * Check if a plugin exists.
     *
     * @param string $name The name of the plugin.
     * @return bool True if the plugin exists, false otherwise.
     */
    public function hasPlugin(string $name): bool
    {
        return isset($this->plugins[$name]);
    }

    /**
     * Get the version of a plugin.
     *
     * @param string $name The name of the plugin.
     * @return string|null The version of the plugin if found, null otherwise.
     */
    public function getVersion(string $name): ?string
    {
        return $this->versions[$name] ?? null;
    }

    /**
     * Get the dependencies of a plugin.
     *
     * @param string $name The name of the plugin.
     * @return array An array of plugin names that this plugin depends on.
     */
    public function getDependencies(string $name): array
    {
        return $this->dependencies[$name] ?? [];
    }

    /**
     * Get all enabled plugins.
     *
     * @return array<string, PluginInterface|callable>
     */
    public function getAll(): array
    {
        return array_filter(
            array_map(
                fn($plugin) => $plugin['plugin'],
                $this->plugins
            ),
            fn($plugin, $key) => $this->plugins[$key]['enabled'],
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * Resolve conflicts between plugins.
     *
     * @param array<array{plugins: array<string>, resolution?: string}> $conflictingPlugins
     * @throws \InvalidArgumentException If the conflict definition is invalid.
     */
    public function resolveConflicts(array $conflictingPlugins): void
    {
        $resolvedConflicts = [];

        foreach ($conflictingPlugins as $conflict) {
            if (!isset($conflict['plugins']) || !is_array($conflict['plugins']) || count($conflict['plugins']) < 2) {
                throw new \InvalidArgumentException("Invalid conflict definition");
            }

            $resolution = $this->resolveConflict($conflict['plugins'], $conflict['resolution'] ?? 'disable');
            $resolvedConflicts[] = $resolution;
        }

        // Apply resolutions
        foreach ($resolvedConflicts as $resolution) {
            foreach ($resolution['disabled'] as $pluginName) {
                $this->disablePlugin($pluginName);
            }
            foreach ($resolution['enabled'] as $pluginName) {
                $this->enablePlugin($pluginName);
            }
        }

        // Reorder plugins based on dependencies and conflicts
        $this->reorderPlugins();
    }

    /**
     * Resolve a conflict between plugins.
     *
     * @param array<string> $conflictingPluginNames
     * @param string $resolutionStrategy
     * @return array{enabled: array<string>, disabled: array<string>}
     * @throws \InvalidArgumentException If the resolution strategy is unknown.
     */
    private function resolveConflict(array $conflictingPluginNames, string $resolutionStrategy): array
    {
        $enabled = [];
        $disabled = [];

        switch ($resolutionStrategy) {
            case 'disable':
                $enabled[] = $conflictingPluginNames[0];
                $disabled = array_slice($conflictingPluginNames, 1);
                break;

            case 'version':
                $highestVersion = '0.0.0';
                $highestVersionPlugin = '';
                foreach ($conflictingPluginNames as $pluginName) {
                    $version = $this->plugins[$pluginName]['version'];
                    if (version_compare($version, $highestVersion, '>')) {
                        $highestVersion = $version;
                        $highestVersionPlugin = $pluginName;
                    }
                }
                $enabled[] = $highestVersionPlugin;
                $disabled = array_diff($conflictingPluginNames, [$highestVersionPlugin]);
                break;

            case 'order':
                foreach ($this->loadOrder as $pluginName) {
                    if (in_array($pluginName, $conflictingPluginNames)) {
                        $enabled[] = $pluginName;
                        $disabled = array_diff($conflictingPluginNames, [$pluginName]);
                        break;
                    }
                }
                break;

            default:
                throw new \InvalidArgumentException("Unknown resolution strategy: {$resolutionStrategy}");
        }

        return [
            'enabled' => $enabled,
            'disabled' => $disabled,
        ];
    }

    /**
     * Disable a plugin.
     *
     * @param string $name The name of the plugin to disable.
     */
    private function disablePlugin(string $name): void
    {
        if (isset($this->plugins[$name])) {
            $this->plugins[$name]['enabled'] = false;
        }
    }

    /**
     * Enable a plugin.
     *
     * @param string $name The name of the plugin to enable.
     */
    private function enablePlugin(string $name): void
    {
        if (isset($this->plugins[$name])) {
            $this->plugins[$name]['enabled'] = true;
        }
    }

    /**
     * Reorder plugins based on dependencies.
     */
    private function reorderPlugins(): void
    {
        $graph = [];
        foreach ($this->plugins as $name => $plugin) {
            $graph[$name] = [];
            if ($plugin['plugin'] instanceof PluginInterface && method_exists($plugin['plugin'], 'getDependencies')) {
                $graph[$name] = $plugin['plugin']->getDependencies();
            }
        }

        $sortedPlugins = $this->topologicalSort($graph);
        $this->loadOrder = array_intersect($sortedPlugins, array_keys($this->getAll()));
    }

    /**
     * Perform a topological sort on the plugin dependency graph.
     *
     * @param array<string, array<string>> $graph
     * @return array<string>
     */
    private function topologicalSort(array $graph): array
    {
        $sorted = [];
        $visiting = [];
        $visited = [];

        foreach ($graph as $node => $dependencies) {
            if (!isset($visited[$node])) {
                $this->visit($node, $graph, $sorted, $visiting, $visited);
            }
        }

        return array_reverse($sorted);
    }

    /**
     * Visit a node in the dependency graph during topological sort.
     *
     * @param string $node
     * @param array<string, array<string>> $graph
     * @param array<string> $sorted
     * @param array<string, bool> $visiting
     * @param array<string, bool> $visited
     * @throws PluginConflictException If a circular dependency is detected.
     */
    private function visit(string $node, array $graph, array &$sorted, array &$visiting, array &$visited): void
    {
        $visiting[$node] = true;

        if (isset($graph[$node])) {
            foreach ($graph[$node] as $dependency) {
                if (isset($visiting[$dependency])) {
                    throw new PluginConflictException("Circular dependency detected: {$node} -> {$dependency}");
                }

                if (!isset($visited[$dependency])) {
                    $this->visit($dependency, $graph, $sorted, $visiting, $visited);
                }
            }
        }

        unset($visiting[$node]);
        $visited[$node] = true;
        $sorted[] = $node;
    }

    /**
     * Register hooks for a plugin.
     *
     * @param string $pluginName The name of the plugin.
     * @param array $hooks An array of hook names and their corresponding callbacks.
     */
    private function registerHooks(string $pluginName, array $hooks): void
    {
        foreach ($hooks as $hookName => $callback) {
            if (!isset($this->hooks[$hookName])) {
                $this->hooks[$hookName] = [];
            }
            $this->hooks[$hookName][] = [$pluginName, $callback];
        }
    }

    /**
     * Execute a hook.
     *
     * @param string $hookName The name of the hook to execute.
     * @param mixed ...$args Additional arguments to pass to the hook callbacks.
     */
    public function executeHook(string $hookName, ...$args)
    {
        if (!isset($this->hooks[$hookName])) {
            return;
        }

        foreach ($this->hooks[$hookName] as [$pluginName, $callback]) {
            if ($this->plugins[$pluginName]['enabled']) {
                $this->executeSandboxed($pluginName, $callback, $args);
            }
        }
    }

    /**
     * Execute a plugin callback in a sandboxed environment.
     *
     * @param string $pluginName The name of the plugin.
     * @param callable $callback The callback to execute.
     * @param array $args Additional arguments to pass to the callback.
     * @return mixed The result of the callback execution.
     */
    private function executeSandboxed(string $pluginName, callable $callback, array $args)
    {
        $sandbox = new PluginSandbox();
        return $sandbox->run($pluginName, $callback, $args);
    }
}

/**
 * PluginSandbox class for executing plugin callbacks in a controlled environment.
 */
class PluginSandbox
{
    /**
     * @var array<string> List of allowed functions in the sandbox.
     */
    private $allowedFunctions = [
        'strlen', 'substr', 'strpos', 'str_replace', 'preg_match', 'preg_replace',
        'array_map', 'array_filter', 'array_reduce', 'array_merge', 'array_push', 'array_pop',
        'json_encode', 'json_decode', 'htmlspecialchars', 'strip_tags'
    ];

    /**
     * Run a plugin callback in a sandboxed environment.
     *
     * @param string $pluginName The name of the plugin.
     * @param callable $callback The callback to execute.
     * @param array $args Additional arguments to pass to the callback.
     * @return mixed The result of the callback execution.
     */
    public function run(string $pluginName, callable $callback, array $args)
    {
        $disabledFunctions = array_diff(get_defined_functions()['internal'], $this->allowedFunctions);
        
        // Disable potentially dangerous functions
        foreach ($disabledFunctions as $function) {
            disable_function($function);
        }

        // Set memory and execution time limits
        ini_set('memory_limit', '32M');
        set_time_limit(5); // 5 seconds max execution time

        try {
            $result = $callback(...$args);
        } catch (\Throwable $e) {
            // Log the error and return null or a default value
            error_log("Error in plugin $pluginName: " . $e->getMessage());
            $result = null;
        } finally {
            // Re-enable functions and reset limits
            foreach ($disabledFunctions as $function) {
                enable_function($function);
            }
            ini_restore('memory_limit');
            set_time_limit(0); // Reset to unlimited
        }

        return $result;
    }
}
