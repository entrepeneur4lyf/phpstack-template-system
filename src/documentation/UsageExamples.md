# Usage Examples

This document provides comprehensive examples of how to use the phpStack Template System in your projects. These examples cover a wide range of functionalities, from basic template rendering to advanced plugin implementation and HTMX integration.

## 1. Basic Template Rendering

Learn how to render a simple template with dynamic data using the `TemplateEngine`.

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\TemplateParser;
use phpStack\TemplateSystem\Core\Template\TemplateRenderer;
use phpStack\TemplateSystem\Core\Plugins\PluginManager;

// Initialize dependencies
$parser = new TemplateParser();
$renderer = new TemplateRenderer(new PluginManager());
$templateEngine = new TemplateEngine($parser, $renderer);

// Define a simple template
$template = "Hello, {[name]}! Welcome to {[company]}.";

// Render the template with data
$result = $templateEngine->render($template, [
    'name' => 'John Doe',
    'company' => 'phpStack'
]);

echo $result; // Outputs: Hello, John Doe! Welcome to phpStack.
```

## 2. Component Usage

Register and render reusable components within your templates.

```php
use phpStack\TemplateSystem\Core\Template\ComponentLibrary;

// Initialize ComponentLibrary
$componentLibrary = new ComponentLibrary();

// Register a simple button component
$componentLibrary->registerComponent('button', function($args, $data) {
    $text = $args['text'] ?? 'Click me';
    $class = $args['class'] ?? 'btn btn-primary';
    return "<button class=\"{$class}\">{$text}</button>";
});

// Use the component in a template
$template = "Here's a button: {[component name='button' text='Submit' class='btn btn-success']}";

$result = $templateEngine->render($template);
echo $result; // Outputs: Here's a button: <button class="btn btn-success">Submit</button>
```

## 3. Plugin Implementation

Extend the system's functionality by implementing custom plugins.

```php
use phpStack\TemplateSystem\Core\Plugins\PluginInterface;

class UppercasePlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $text = $args['text'] ?? '';
        return strtoupper($text);
    }
}

// Register the plugin
$pluginManager = new PluginManager();
$pluginManager->registerPlugin('uppercase', new UppercasePlugin());

// Use the plugin in a template
$template = "Loud greeting: {[uppercase text='hello world']}";

$result = $templateEngine->render($template);
echo $result; // Outputs: Loud greeting: HELLO WORLD
```

## 4. HTMX Integration

Integrate HTMX to enable dynamic content updates without full page reloads.

```php
use phpStack\TemplateSystem\Core\Template\HtmxComponents;

// Initialize HtmxComponents
$htmxComponents = new HtmxComponents($templateEngine);

// Register an HTMX-enabled component
$htmxComponents->registerComponent('dynamic-content', function($args, $data) {
    $url = $args['url'] ?? '/api/content';
    return "<div hx-get=\"{$url}\" hx-trigger=\"load\">Loading...</div>";
});

// Use the HTMX component in a template
$template = "<h1>Dynamic Content Example</h1>{[component name='dynamic-content' url='/api/latest-news']}";

$result = $templateEngine->render($template);
echo $result;
// Outputs:
// <h1>Dynamic Content Example</h1>
// <div hx-get="/api/latest-news" hx-trigger="load">Loading...</div>
```

## 5. Caching and Performance Profiling

Utilize caching to improve performance and use the performance profiler to monitor rendering times.

```php
use phpStack\TemplateSystem\Core\Cache\CacheManager;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;

// Initialize CacheManager and PerformanceProfiler
$cacheManager = new CacheManager();
$profiler = new PerformanceProfiler();

// Configure TemplateEngine with caching and profiling
$templateEngine->setCacheManager($cacheManager);
$templateEngine->setProfiler($profiler);

// Render a template with caching
$cacheKey = 'home_page_' . md5(json_encode($data));
$result = $templateEngine->renderCached('home', $data, $cacheKey, 3600); // Cache for 1 hour

// Get profiling results
$renderTime = $profiler->getLastRenderTime();
echo "Template rendered in {$renderTime} seconds";
```

## 6. Plugin Conflict Resolution

Manage plugin conflicts and dependencies using the `PluginManager`.

```php
use phpStack\TemplateSystem\Core\Plugins\PluginManager;

$pluginManager = new PluginManager();

// Register plugins
$pluginManager->registerPlugin('pluginA', new PluginA(), '1.0.0');
$pluginManager->registerPlugin('pluginB', new PluginB(), '2.0.0');
$pluginManager->registerPlugin('pluginC', new PluginC(), '1.5.0');

// Define conflicts and resolutions
$pluginManager->resolveConflicts([
    ['plugins' => ['pluginA', 'pluginB'], 'resolution' => 'version'],
    ['plugins' => ['pluginB', 'pluginC'], 'resolution' => 'order']
]);

// Use plugins in a template
$template = "{[pluginA]} {[pluginB]} {[pluginC]}";
$result = $templateEngine->render($template);
```

## 7. Advanced Component with Lifecycle Hooks

Create a more complex component with lifecycle hooks and HTMX integration.

```php
use phpStack\TemplateSystem\Core\Template\ComponentDesigner;

$componentDesigner = new ComponentDesigner($templateEngine, $pluginManager);

$componentDesigner->createComponent('data-table', [
    'attributes' => ['id', 'class'],
    'content' => '<table id="{{id}}" class="{{class}}">{{content}}</table>',
    'script' => '
        htmx.on("load", function() {
            console.log("Data table loaded");
        });
        htmx.on("beforeRequest", function(evt) {
            console.log("Loading data...");
        });
    ',
    'style' => '
        .data-table { border-collapse: collapse; width: 100%; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; }
    '
]);

// Use the advanced component in a template
$template = '
    {[component name="data-table" id="users-table" class="data-table striped"]
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>
        </thead>
        <tbody hx-get="/api/users" hx-trigger="load">
            <tr><td colspan="3">Loading users...</td></tr>
        </tbody>
    [/component]}
';

$result = $templateEngine->render($template);
echo $result;
```

These examples demonstrate the versatility and power of the phpStack Template System. For more detailed examples and best practices, refer to the [Examples Directory](../Examples) in the project repository. These examples provide practical, runnable code that developers can use to understand how to implement and use various features of the phpStack Template System in their projects.

Remember to always consider security implications when working with user inputs and dynamic content. Refer to the [Security Best Practices](Security_Best_Practices.md) guide for more information on securing your applications built with phpStack.
