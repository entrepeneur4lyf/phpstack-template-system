# Usage Examples

This document provides practical examples of how to use the phpStack Template System in your projects. These examples cover a range of functionalities, from basic template rendering to advanced plugin implementation and HTMX integration.

## Basic Template Rendering

Learn how to render a simple template with dynamic data. This example demonstrates how to use the `TemplateEngine` to render a template with provided data.

```php
$templateEngine = new TemplateEngine(...);
echo $templateEngine->render('template_name', ['key' => 'value']);
```

## Component Usage

Register and render components within your templates. Components allow you to encapsulate reusable pieces of UI logic.

```php
$templateEngine->registerComponent('component_name', function($args, $data) {
    return "<div>{$data['content']}</div>";
});
```

## Plugin Implementation

Extend the system's functionality by implementing custom plugins. Plugins can modify or extend the behavior of the template system.

```php
class CustomPlugin implements PluginInterface {
    public function execute(array $args, array $data) {
        // Plugin logic here
    }
}
```

## HTMX Integration

Integrate HTMX to enable dynamic content updates without full page reloads. This example shows how to use HTMX attributes in your components.

```php
$templateEngine->registerComponent('dynamic_component', function($args, $data) {
    return "<div hx-get='/update' hx-trigger='click'>{$data['content']}</div>";
});
```

## Caching and Performance Profiling

Utilize caching to improve performance and use the performance profiler to monitor rendering times.

```php
$cacheManager = new CacheManager(...);
$templateEngine->setCacheManager($cacheManager);

$profiler = new PerformanceProfiler();
$templateEngine->setProfiler($profiler);
```

## Plugin Conflict Resolution

Manage plugin conflicts and dependencies using the `PluginManager`.

```php
$pluginManager = new PluginManager();
$pluginManager->resolveConflicts([
    ['plugins' => ['pluginA', 'pluginB'], 'resolution' => 'version']
]);
```

For more examples, refer to the [Examples Directory](../Examples). These examples provide practical, runnable code that developers can use to understand how to implement and use various features of the phpStack Template System in their projects.
