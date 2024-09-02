# phpStack Template System Usage Guide

## Installation

You can install the phpStack Template System via Composer:

```bash
composer require phpStack/template-system
```

## Basic Usage

### Initializing the Template Engine

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$templateDir = '/path/to/your/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);
```

### Rendering a Template

```php
$data = ['name' => 'John Doe'];
$renderedTemplate = $engine->render('user_profile.php', $data);
echo $renderedTemplate;
```

### Registering a Component

```php
$engine->registerComponent('user-card', function($args, $data) {
    return "<div class=\"user-card\">{$data['name']}</div>";
}, '.user-card { border: 1px solid #ccc; padding: 10px; }');
```

### Using HTMX Components

```php
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;

$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// In your template
echo HtmxComponents::ButtonComponent::render([
    'text' => 'Click me',
    'hx-post' => '/api/endpoint',
    'hx-target' => '#result'
]);
```

## Advanced Usage

### Creating a Custom Plugin

```php
use phpStack\TemplateSystem\Core\Plugins\PluginInterface;

class CustomPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        // Plugin logic here
    }
}

HtmxComponents::registerPlugin('custom-plugin', new CustomPlugin(), '1.0.0');
```

### Implementing Dynamic Behavior with HTMX

```php
// In your PHP controller
public function getUserList($request, $response) {
    $users = $this->userService->getUsers();
    $userListHtml = '';
    foreach ($users as $user) {
        $userListHtml .= HtmxComponents::ListItemComponent::render([
            'content' => $user->name,
            'hx-get' => "/user/{$user->id}",
            'hx-target' => '#user-details'
        ]);
    }
    return $response->getBody()->write($userListHtml);
}

// In your template
<div id="user-list" hx-get="/users" hx-trigger="load">
    Loading users...
</div>
<div id="user-details"></div>
```

## Best Practices

1. Use components for reusable UI elements.
2. Leverage HTMX for dynamic interactions to reduce JavaScript usage.
3. Implement caching for frequently used templates and components.
4. Use the PerformanceProfiler to identify and optimize slow-rendering parts of your application.
5. Create custom plugins to extend functionality without modifying core code.

## Additional Resources

- [HTMX Documentation](https://htmx.org/docs/)
- [PHP PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Composer Documentation](https://getcomposer.org/doc/)

For more detailed information about each component of the system, please refer to the API documentation.