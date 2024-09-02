<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Plugins\PluginManager;
use phpStack\TemplateSystem\Core\Template\PluginInterface;

class Plugin1 implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        return "Result from Plugin1 (v1.0)";
    }

    public function getDependencies(): array
    {
        return [];
    }
}

class Plugin2 implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        return "Result from Plugin2 (v2.0)";
    }

    public function getDependencies(): array
    {
        return [];
    }
}

class Plugin3 implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        return "Result from Plugin3 (v1.5)";
    }

    public function getDependencies(): array
    {
        return [];
    }
}

$pluginManager = new PluginManager();

// Register plugins
$pluginManager->registerPlugin('plugin1', new Plugin1(), '1.0');
$pluginManager->registerPlugin('plugin2', new Plugin2(), '2.0');
$pluginManager->registerPlugin('plugin3', new Plugin3(), '1.5');

// Define conflicts
$conflicts = [
    [
        'plugins' => ['plugin1', 'plugin2'],
        'resolution' => 'version'
    ],
    [
        'plugins' => ['plugin2', 'plugin3'],
        'resolution' => 'order'
    ]
];

// Resolve conflicts
$pluginManager->resolveConflicts($conflicts);

// Get all enabled plugins
$enabledPlugins = $pluginManager->getAll();

echo "Enabled plugins after conflict resolution:\n";
foreach ($enabledPlugins as $name => $plugin) {
    echo "- {$name}\n";
    echo "  Result: " . $plugin['plugin']->execute([], []) . "\n";
}