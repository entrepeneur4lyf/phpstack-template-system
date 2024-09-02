# Tutorial 3: Plugin Implementation

This tutorial will guide you through creating and using plugins in the phpStack Template System.

## Step 1: Create a Custom Plugin

Let's create a simple plugin that converts text to uppercase:

```php
use phpStack\TemplateSystem\Core\Plugins\PluginInterface;

class UppercasePlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $text = $args['text'] ?? '';
        return strtoupper($text);
    }

    public function getDependencies(): array
    {
        return []; // This plugin has no dependencies
    }
}
```

## Step 2: Register the Plugin

Now, let's register our plugin with the PluginManager:

```php
use phpStack\TemplateSystem\Core\Plugins\PluginManager;

$pluginManager = new PluginManager();
$pluginManager->registerPlugin('uppercase', new UppercasePlugin(), '1.0.0');
```

## Step 3: Set Up the Template Engine

Make sure your TemplateEngine is set up with the PluginManager:

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\TemplateParser;
use phpStack\TemplateSystem\Core\Template\TemplateRenderer;

$parser = new TemplateParser();
$renderer = new TemplateRenderer($pluginManager);
$templateEngine = new TemplateEngine($parser, $renderer);
```

## Step 4: Use the Plugin in a Template

Now, let's create a template that uses our new uppercase plugin:

```php
$template = "Normal text: {[uppercase text='hello world']}";
```

## Step 5: Render the Template

Finally, let's render the template:

```php
$result = $templateEngine->render($template);
echo $result;
```

This will output: `Normal text: HELLO WORLD`

## Step 6: Create a More Complex Plugin

Let's create a more complex plugin that formats dates:

```php
class DateFormatterPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $date = $args['date'] ?? 'now';
        $format = $args['format'] ?? 'Y-m-d H:i:s';
        
        $dateTime = new DateTime($date);
        return $dateTime->format($format);
    }

    public function getDependencies(): array
    {
        return []; // This plugin has no dependencies
    }
}

// Register the new plugin
$pluginManager->registerPlugin('format_date', new DateFormatterPlugin(), '1.0.0');
```

## Step 7: Use the Complex Plugin

Now let's use our new date formatter plugin in a template:

```php
$template = "
    Current date: {[format_date]}
    Formatted date: {[format_date date='2023-06-15' format='F j, Y']}
";

$result = $templateEngine->render($template);
echo $result;
```

This might output something like:
```
Current date: 2023-06-10 14:30:45
Formatted date: June 15, 2023
```

## Conclusion

You've now learned how to create, register, and use both simple and complex plugins in the phpStack Template System. Plugins allow you to extend the functionality of your templates, enabling you to process data, format output, and add new features to your templating system. In the next tutorial, we'll explore how to integrate HTMX with the phpStack Template System for dynamic content updates.
