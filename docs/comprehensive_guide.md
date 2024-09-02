# phpStack Template System - Comprehensive Guide

## Table of Contents

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Core Components](#core-components)
   - [TemplateEngine](#templateengine)
   - [HtmxComponents](#htmxcomponents)
   - [ComponentPlugin](#componentplugin)
   - [PluginManager](#pluginmanager)
   - [PluginSandbox](#pluginsandbox)
4. [Security Features](#security-features)
5. [Usage Guide](#usage-guide)
   - [Basic Template Rendering](#basic-template-rendering)
   - [Working with Components](#working-with-components)
   - [Implementing Plugins](#implementing-plugins)
   - [HTMX Integration](#htmx-integration)
6. [Advanced Features](#advanced-features)
   - [Caching](#caching)
   - [Performance Profiling](#performance-profiling)
   - [Lazy Loading](#lazy-loading)
7. [Plugin Conflict Resolution](#plugin-conflict-resolution)
8. [Best Practices](#best-practices)
9. [Troubleshooting](#troubleshooting)
10. [API Reference](#api-reference)

## 1. Introduction

The phpStack Template System is a powerful and flexible package for PHP applications that provides template rendering, component management, and plugin support with HTMX integration. It offers a secure environment for executing plugins, advanced caching mechanisms, and tools for performance optimization.

## 2. Installation

To install the phpStack Template System, use Composer:

```bash
composer require phpStack/template-system
```

## 3. Core Components

### TemplateEngine

The TemplateEngine is the central class for rendering templates and managing components.

Key features:
- Template rendering with variable interpolation
- Caching support for improved performance
- Component registration and management
- Global asset (CSS and JS) injection

Example usage:

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Psr\Cache\CacheItemPoolInterface;

$templateDir = '/path/to/templates';
$profiler = new PerformanceProfiler();
$cache = /* PSR-6 compatible cache implementation */;

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Render a template
$data = ['name' => 'John Doe'];
$renderedTemplate = $engine->render('user_profile.php', $data);

// Register a component
$engine->registerComponent('user-card', function($args, $data) {
    return "<div class=\"user-card\">{$data['name']}</div>";
}, '.user-card { border: 1px solid #ccc; padding: 10px; }');
```

### HtmxComponents

HtmxComponents provides integration with HTMX, allowing for dynamic, interactive web applications with minimal JavaScript.

Key features:
- Pre-built HTMX-compatible components
- Support for HTMX attributes and events
- Integration with the TemplateEngine

Example usage:

```php
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;

$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Use an HTMX component
echo HtmxComponents::ButtonComponent::render([
    'text' => 'Click me',
    'hx-post' => '/api/endpoint',
    'hx-target' => '#result'
]);
```

### ComponentPlugin

The ComponentPlugin manages the rendering and caching of individual components.

Key features:
- Server-side and client-side rendering options
- Support for Shadow DOM
- Asynchronous rendering using PHP Fibers (PHP 8.1+)
- Component dependency management

Example usage:

```php
use phpStack\TemplateSystem\Core\Template\Plugins\ComponentPlugin;

$componentPlugin = $engine->getComponentPlugin();

// Register a component with dependencies
$componentPlugin->register('advanced-chart', function($args, $data) {
    // Component logic here
}, null, null, [], ['data-processor', 'chart-library']);

// Render a component
$renderedComponent = $componentPlugin->execute([
    'name' => 'advanced-chart',
    'shadowDom' => true,
    'async' => true
], $chartData);
```

### PluginManager

The PluginManager handles plugin registration, management, and conflict resolution.

Key features:
- Plugin registration and version tracking
- Conflict resolution with multiple strategies
- Dependency management and circular dependency detection
- Plugin enabling/disabling

Example usage:

```php
use phpStack\TemplateSystem\Core\Plugins\PluginManager;

$pluginManager = new PluginManager();

// Register plugins
$pluginManager->registerPlugin('data-processor', new DataProcessorPlugin(), '1.0');
$pluginManager->registerPlugin('chart-library', new ChartLibraryPlugin(), '2.0');

// Define and resolve conflicts
$conflicts = [
    [
        'plugins' => ['data-processor', 'legacy-processor'],
        'resolution' => 'version'
    ]
];
$pluginManager->resolveConflicts($conflicts);

// Get all enabled plugins
$enabledPlugins = $pluginManager->getAll();
```

### PluginSandbox

The PluginSandbox provides a secure environment for executing plugin code.

Key features:
- Restricted file system access
- Disabled dangerous PHP functions
- Memory and execution time limits
- Exception handling and security policy restoration

Example usage:

```php
use phpStack\TemplateSystem\Core\Template\PluginSandbox;
use phpStack\TemplateSystem\Core\Security\SandboxSecurityPolicy;

$securityPolicy = new SandboxSecurityPolicy();
$sandbox = new PluginSandbox($securityPolicy);

try {
    $result = $sandbox->execute($pluginFunction, $args, $data);
} catch (\RuntimeException $e) {
    // Handle plugin execution error
}
```

## 4. Security Features

The phpStack Template System implements several security measures:

1. **File system restrictions**: The PluginSandbox uses `open_basedir` to restrict file system access to the temporary directory.

2. **Function disabling**: Potentially dangerous PHP functions are disabled during plugin execution.

3. **Memory and execution time limits**: Plugins are restricted in their resource usage.

4. **Sandboxed execution**: All plugin code is executed within a controlled environment.

5. **Exception handling**: Exceptions during plugin execution are caught and rethrown, ensuring that the security policy is always restored.

## 5. Usage Guide

### Basic Template Rendering

```php
// Assuming $engine is an instance of TemplateEngine

// Create a template file: templates/hello.php
// <?php echo "Hello, {$name}!"; ?>

$data = ['name' => 'World'];
$rendered = $engine->render('hello.php', $data);
echo $rendered; // Outputs: Hello, World!
```

### Working with Components

```php
// Register a component
$engine->registerComponent('user-profile', function($args, $data) {
    $name = $data['name'] ?? 'Guest';
    $email = $data['email'] ?? 'N/A';
    return "<div class=\"user-profile\">
                <h2>{$name}</h2>
                <p>Email: {$email}</p>
            </div>";
});

// Use the component in a template
// <?php echo $this->renderComponent('user-profile', ['name' => 'John', 'email' => 'john@example.com']); ?>
```

### Implementing Plugins

```php
use phpStack\TemplateSystem\Core\Template\PluginInterface;

class MarkdownPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $markdown = $args['content'] ?? '';
        // Convert markdown to HTML (implementation omitted)
        return $this->convertToHtml($markdown);
    }

    public function getDependencies(): array
    {
        return []; // This plugin has no dependencies
    }
}

$pluginManager->registerPlugin('markdown', new MarkdownPlugin(), '1.0');

// Use the plugin in a template
// <?php echo $this->executePlugin('markdown', ['content' => '# Hello World']); ?>
```

### HTMX Integration

```php
// In your PHP controller
public function handleHtmxRequest($request, $response) {
    $handler = new HtmxRequestHandler();
    return $handler->handle($request, $response, [
        'swapTargets' => [
            '#content' => '<p>New content loaded via HTMX!</p>'
        ],
        'triggerEvents' => ['contentLoaded']
    ]);
}

// In your template
<div hx-get="/api/content" hx-trigger="load" hx-target="#content" hx-swap="innerHTML">
    <p>Loading...</p>
</div>

<div id="content"></div>

<script>
    document.body.addEventListener('contentLoaded', function(event) {
        console.log('New content has been loaded');
    });
</script>
```

## 6. Advanced Features

### Caching

The TemplateEngine uses a PSR-6 compatible cache for storing rendered templates and components. To implement caching:

1. Choose a PSR-6 compatible cache implementation (e.g., Symfony Cache).
2. Pass the cache instance to the TemplateEngine constructor.

```php
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$cache = new FilesystemAdapter();
$engine = new TemplateEngine($templateDir, $profiler, $cache);
```

### Performance Profiling

The PerformanceProfiler class allows you to measure the rendering time of templates and components.

```php
$profiler = $engine->getProfiler();
$metrics = $profiler->getAllProfiles();

foreach ($metrics as $name => $duration) {
    echo "{$name}: {$duration} seconds\n";
}
```

### Lazy Loading

Components and plugins can be lazy-loaded to improve performance:

```php
$componentPlugin->registerLazy('heavy-component', function() {
    return function($args, $data) {
        // Complex component logic here
    };
});
```

## 7. Plugin Conflict Resolution

The PluginManager provides advanced conflict resolution capabilities:

```php
$conflicts = [
    [
        'plugins' => ['plugin1', 'plugin2'],
        'resolution' => 'version' // Use the highest version
    ],
    [
        'plugins' => ['plugin3', 'plugin4'],
        'resolution' => 'order' // Keep the first loaded plugin
    ],
    [
        'plugins' => ['plugin5', 'plugin6'],
        'resolution' => 'disable' // Disable all but the first plugin
    ]
];

$pluginManager->resolveConflicts($conflicts);
```

Resolution strategies:
- `version`: Enable the plugin with the highest version number
- `order`: Keep the plugin that was loaded first
- `disable`: Disable all conflicting plugins except the first one

## 8. Best Practices

1. **Use components for reusable UI elements**: Break down your UI into small, reusable components.
2. **Leverage HTMX for dynamic interactions**: Reduce the need for custom JavaScript by using HTMX attributes.
3. **Implement caching**: Use caching for frequently used templates and components to improve performance.
4. **Profile your application**: Regularly use the PerformanceProfiler to identify and optimize slow-rendering parts.
5. **Secure plugin execution**: Always use the PluginSandbox when executing third-party or user-provided plugin code.
6. **Manage plugin conflicts**: Use the conflict resolution system to handle plugin incompatibilities gracefully.
7. **Lazy load when possible**: Use lazy loading for heavy components or plugins that are not immediately needed.

## 9. Troubleshooting

Common issues and solutions:

1. **Slow rendering times**: 
   - Enable caching
   - Use the PerformanceProfiler to identify bottlenecks
   - Consider lazy loading for heavy components

2. **Plugin conflicts**: 
   - Use the PluginManager's conflict resolution system
   - Ensure plugins declare their dependencies correctly

3. **Security concerns**: 
   - Always use the PluginSandbox for executing plugin code
   - Regularly update the list of disabled functions in SandboxSecurityPolicy

4. **HTMX integration issues**: 
   - Ensure HTMX is properly loaded in your frontend
   - Check browser console for JavaScript errors
   - Verify that your server is correctly handling HTMX requests

## 10. API Reference

For detailed API documentation of all classes and methods, please refer to the `api_reference.md` file in the `docs` directory.

This comprehensive guide should provide a thorough understanding of the phpStack Template System, its features, and best practices for using it effectively in your projects.