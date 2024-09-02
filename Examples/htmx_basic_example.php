<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\ButtonComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;

$engine = new TemplateEngine();
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

$button = ButtonComponent::render([
    'text' => 'Load Content',
    'hx-get' => '/api/content',
    'hx-target' => '#content'
], []);

$content = DivComponent::render([
    'id' => 'content',
    'content' => 'Click the button to load content.'
], []);

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTMX Basic Example</title>
    <script src="https://unpkg.com/htmx.org@1.9.2"></script>
</head>
<body>
    <h1>HTMX Basic Example</h1>
    {$button}
    {$content}
</body>
</html>
HTML;

echo $html;