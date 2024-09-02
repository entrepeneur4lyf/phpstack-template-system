# Tutorial 2: Component Usage

This tutorial will guide you through creating and using reusable components in the phpStack Template System.

## Step 1: Set up the Component Library

First, let's set up the ComponentLibrary:

```php
use phpStack\TemplateSystem\Core\Template\ComponentLibrary;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;

$componentLibrary = new ComponentLibrary();
$templateEngine = new TemplateEngine(/* ... other dependencies ... */);
$templateEngine->setComponentLibrary($componentLibrary);
```

## Step 2: Create a Simple Component

Let's create a simple button component:

```php
$componentLibrary->registerComponent('button', function($args, $data) {
    $text = $args['text'] ?? 'Click me';
    $class = $args['class'] ?? 'btn btn-primary';
    return "<button class=\"{$class}\">{$text}</button>";
});
```

## Step 3: Use the Component in a Template

Now, let's create a template that uses our new button component:

```php
$template = "Here's a button: {[component name='button' text='Submit' class='btn btn-success']}";
```

## Step 4: Render the Template

Finally, let's render the template:

```php
$result = $templateEngine->render($template);
echo $result;
```

This will output: `Here's a button: <button class="btn btn-success">Submit</button>`

## Step 5: Create a More Complex Component

Let's create a more complex component with multiple parts:

```php
$componentLibrary->registerComponent('card', function($args, $data) {
    $title = $args['title'] ?? 'Card Title';
    $content = $args['content'] ?? 'Card content goes here.';
    $footer = $args['footer'] ?? '';
    
    return "
        <div class='card'>
            <div class='card-header'>{$title}</div>
            <div class='card-body'>{$content}</div>
            " . ($footer ? "<div class='card-footer'>{$footer}</div>" : "") . "
        </div>
    ";
});
```

## Step 6: Use the Complex Component

Now let's use our new card component in a template:

```php
$template = "
    <h1>Welcome to My Page</h1>
    {[component name='card' 
        title='Featured Article' 
        content='This is a great article about components.' 
        footer='Read more...'
    ]}
";

$result = $templateEngine->render($template);
echo $result;
```

## Conclusion

You've now learned how to create and use both simple and complex components in the phpStack Template System. Components allow you to create reusable pieces of UI that can be easily inserted into your templates, promoting code reuse and maintainability. In the next tutorial, we'll explore how to implement and use plugins to extend the functionality of your templates.
