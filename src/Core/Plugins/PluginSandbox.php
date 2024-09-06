<?php

namespace phpStack\Core\Plugins;

/**
 * PluginSandbox class for executing plugins in a controlled environment.
 *
 * This class provides a sandbox environment for executing plugin code
 * with limited access to PHP functions and classes for security purposes.
 */
class PluginSandbox
{
    /**
     * @var array List of allowed PHP functions in the sandbox environment.
     */
    private $allowedFunctions = [
        'strlen', 'substr', 'strtolower', 'strtoupper', 'trim',
        'implode', 'explode', 'array_map', 'array_filter', 'array_reduce',
        'json_encode', 'json_decode', 'htmlspecialchars', 'preg_replace'
    ];

    /**
     * @var array List of allowed PHP classes in the sandbox environment.
     */
    private $allowedClasses = [
        'DateTime', 'DateTimeImmutable', 'DateInterval', 'DateTimeZone'
    ];

    /**
     * Execute a plugin in the sandbox environment.
     *
     * @param callable $plugin The plugin function to execute.
     * @param array $args Arguments to pass to the plugin function.
     * @param array $data Additional data available to the plugin.
     * @return mixed The result of the plugin execution.
     */
    public function execute(callable $plugin, array $args, array $data)
    {
        $sandbox = function () use ($plugin, $args) {
            $allowedFunctions = $this->allowedFunctions;
            $allowedClasses = $this->allowedClasses;

            return eval(
                'use ' . implode(', ', $allowedClasses) . ';' .
                'foreach ($allowedFunctions as $func) { if (!function_exists($func)) { function $func(...$args) { return call_user_func_array($func, $args); } } }' .
                'return ($plugin)(...$args);'
            );
        };

        return $sandbox->bindTo(null, null)();
    }
}
