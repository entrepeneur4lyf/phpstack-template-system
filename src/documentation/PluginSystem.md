# Plugin System Documentation

The plugin system allows for extending the functionality of the phpStack Template System.

## Creating Plugins

Implement the `PluginInterface` to create custom plugins.

```php
class MyPlugin implements PluginInterface {
    public function execute(array $args, array $data) {
        // Plugin logic
    }
}
```

## Registering Plugins

Use the `PluginManager` to register and manage plugins.

```php
$pluginManager->registerPlugin('my_plugin', new MyPlugin(), '1.0.0');
```

## Managing Dependencies

Define dependencies between plugins to ensure proper load order.

```php
$pluginManager->registerPlugin('dependent_plugin', new DependentPlugin(), '1.0.0', ['my_plugin']);
```

For more information, refer to the [PluginManager API](PluginManagerAPI.md).
