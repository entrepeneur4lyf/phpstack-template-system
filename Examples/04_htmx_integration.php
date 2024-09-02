<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$templateDir = __DIR__ . '/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Register HTMX components
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create a template that uses HTMX components
file_put_contents(__DIR__ . '/templates/htmx_example.php', '
<!DOCTYPE html>
<html>
<head>
    <title>HTMX Example</title>
    <script src="https://unpkg.com/htmx.org@2.0.2" integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ" crossorigin="anonymous"></script>
</head>
<body>
    <h1>HTMX Example</h1>
    <?php
    echo HtmxComponents::ButtonComponent::render([
        "text" => "Click me",
        "hx-post" => "/api/greet",
        "hx-target" => "#greeting"
    ]);
    ?>
    <div id="greeting"></div>

    <?php
    echo HtmxComponents::FormComponent::render([
        "content" => \'
            <input type="text" name="name" placeholder="Enter your name">
            <button type="submit">Submit</button>
        \',
        "hx-post" => "/api/submit",
        "hx-target" => "#form-result"
    ]);
    ?>
    <div id="form-result"></div>
</body>
</html>
');

// Render the template
$rendered = $engine->render('htmx_example.php', []);

echo $rendered;

// Simulate API endpoints for HTMX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_URI'] === '/api/greet') {
        echo "Hello, HTMX!";
        exit;
    } elseif ($_SERVER['REQUEST_URI'] === '/api/submit') {
        $name = $_POST['name'] ?? 'Guest';
        echo "Thank you for submitting, {$name}!";
        exit;
    }
}