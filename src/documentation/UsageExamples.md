# Usage Examples

This document provides practical examples of how to use the phpStack Template System in your projects.

## Basic Template Rendering

Learn how to render a simple template with dynamic data.

```php
$templateEngine = new TemplateEngine(...);
echo $templateEngine->render('template_name', ['key' => 'value']);
```

## Component Usage

Register and render components within your templates.

```php
$templateEngine->registerComponent('component_name', function($args, $data) {
    return "<div>{$data['content']}</div>";
});
```

## Plugin Implementation

Extend the system's functionality by implementing custom plugins.

```php
class CustomPlugin implements PluginInterface {
    public function execute(array $args, array $data) {
        // Plugin logic here
    }
}
```

For more examples, refer to the [Examples Directory](../Examples).
