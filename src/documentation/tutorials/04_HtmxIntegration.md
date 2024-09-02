# Tutorial 4: HTMX Integration

This tutorial will guide you through integrating HTMX with the phpStack Template System for dynamic content updates without full page reloads.

## Step 1: Set Up HTMX

First, make sure you've included the HTMX library in your HTML. You can do this by adding the following line to your `<head>` section:

```html
<script src="https://unpkg.com/htmx.org@1.9.2"></script>
```

## Step 2: Create an HTMX-Enabled Component

Let's create a component that uses HTMX attributes:

```php
use phpStack\TemplateSystem\Core\Template\HtmxComponents;

$htmxComponents = new HtmxComponents($templateEngine);

$htmxComponents->registerComponent('dynamic-content', function($args, $data) {
    $url = $args['url'] ?? '/api/content';
    $trigger = $args['trigger'] ?? 'load';
    return "<div hx-get=\"{$url}\" hx-trigger=\"{$trigger}\">Loading...</div>";
});
```

## Step 3: Use the HTMX Component in a Template

Now, let's create a template that uses our new HTMX-enabled component:

```php
$template = "
    <h1>Dynamic Content Example</h1>
    {[component name='dynamic-content' url='/api/latest-news' trigger='load']}
";
```

## Step 4: Render the Template

Render the template as usual:

```php
$result = $templateEngine->render($template);
echo $result;
```

This will output:
```html
<h1>Dynamic Content Example</h1>
<div hx-get="/api/latest-news" hx-trigger="load">Loading...</div>
```

## Step 5: Create an API Endpoint

For this example to work, you need to create an API endpoint that returns the content. Here's a simple example using PHP:

```php
// In your /api/latest-news.php file
<?php
header('Content-Type: text/html');
echo "<ul>
    <li>News Item 1</li>
    <li>News Item 2</li>
    <li>News Item 3</li>
</ul>";
```

## Step 6: Create a More Complex HTMX Component

Let's create a more complex component that uses multiple HTMX attributes:

```php
$htmxComponents->registerComponent('interactive-form', function($args, $data) {
    $action = $args['action'] ?? '/submit';
    $target = $args['target'] ?? '#result';
    return "
        <form hx-post=\"{$action}\" hx-target=\"{$target}\">
            <input type=\"text\" name=\"username\" placeholder=\"Enter username\">
            <button type=\"submit\">Submit</button>
        </form>
        <div id=\"result\"></div>
    ";
});
```

## Step 7: Use the Complex HTMX Component

Now let's use our new interactive form component:

```php
$template = "
    <h1>Interactive Form</h1>
    {[component name='interactive-form' action='/api/submit-form' target='#form-result']}
    <div id=\"form-result\"></div>
";

$result = $templateEngine->render($template);
echo $result;
```

## Step 8: Handle the HTMX Request

Finally, create a PHP file to handle the form submission:

```php
// In your /api/submit-form.php file
<?php
header('Content-Type: text/html');
$username = $_POST['username'] ?? 'Guest';
echo "<p>Thank you for submitting, {$username}!</p>";
```

## Conclusion

You've now learned how to integrate HTMX with the phpStack Template System. This powerful combination allows you to create dynamic, interactive web applications with minimal JavaScript. HTMX handles the client-side interactions, while your PHP backend (using the phpStack Template System) generates and serves the content. In the next tutorial, we'll explore advanced features like caching and performance profiling.
