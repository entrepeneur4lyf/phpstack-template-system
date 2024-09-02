<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use phpStack\TemplateSystem\Core\Plugins\PluginManager;
use phpStack\TemplateSystem\Examples\Plugins\MarkdownPlugin;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$templateDir = __DIR__ . '/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Create a PluginManager and register the MarkdownPlugin
$pluginManager = new PluginManager();
$pluginManager->registerPlugin('markdown', new MarkdownPlugin(), '1.0');

// Create a template that uses the plugin
file_put_contents(__DIR__ . '/templates/markdown_page.php', '
<!DOCTYPE html>
<html>
<head>
    <title>Markdown Example</title>
</head>
<body>
    <h1>Markdown to HTML conversion</h1>
    <div>
        <?php echo $this->executePlugin("markdown", ["content" => $markdown_content]); ?>
    </div>
</body>
</html>
');

// Render the template
$data = [
    'markdown_content' => "# Welcome to Markdown\n\nThis is a **bold** statement.\nAnd this is *italic*.\n\n## Subheading\n\nMore content here."
];
$rendered = $engine->render('markdown_page.php', $data);

echo $rendered;