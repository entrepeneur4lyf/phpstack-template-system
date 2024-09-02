# Tutorial 1: Basic Template Rendering

This tutorial will guide you through the process of rendering a simple template using the phpStack Template System.

## Step 1: Set up the Template Engine

First, let's set up the basic components needed for template rendering:

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\TemplateParser;
use phpStack\TemplateSystem\Core\Template\TemplateRenderer;
use phpStack\TemplateSystem\Core\Plugins\PluginManager;

$parser = new TemplateParser();
$pluginManager = new PluginManager();
$renderer = new TemplateRenderer($pluginManager);
$templateEngine = new TemplateEngine($parser, $renderer);
```

## Step 2: Create a Simple Template

Now, let's create a simple template string:

```php
$template = "Hello, {[name]}! Welcome to {[company]}.";
```

In this template, `{[name]}` and `{[company]}` are placeholders that will be replaced with actual values.

## Step 3: Prepare Data for the Template

Next, we'll prepare the data to be inserted into the template:

```php
$data = [
    'name' => 'John Doe',
    'company' => 'phpStack'
];
```

## Step 4: Render the Template

Finally, let's render the template with our data:

```php
$result = $templateEngine->render($template, $data);
echo $result;
```

This will output: `Hello, John Doe! Welcome to phpStack.`

## Conclusion

You've now successfully rendered a basic template using the phpStack Template System. This simple example demonstrates the core functionality of template rendering. In the next tutorials, we'll explore more advanced features like components, plugins, and HTMX integration.
