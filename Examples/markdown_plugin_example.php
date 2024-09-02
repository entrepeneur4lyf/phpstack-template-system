<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginManager;
use phpStack\TemplateSystem\Examples\Plugins\MarkdownPlugin;
use phpStack\TemplateSystem\Core\Template\DivComponent;

// Initialize TemplateEngine and HTMX integration
$engine = new TemplateEngine('Examples/templates');
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create HtmxViewHelper
$htmxHelper = new HtmxViewHelper($config);

// Create and register the MarkdownPlugin
$pluginManager = new HtmxPluginManager();
$pluginManager->registerHtmxPlugin('markdown', new MarkdownPlugin(), '1.0.0');

$markdown_text = <<<HTML
{{markdown}}
# Welcome to the Enhanced Markdown Plugin

This plugin now supports a wide range of Reddit-style Markdown features.

## Text Formatting

You can make text **bold**, *italic*, or ***both***. You can also ~~strikethrough~~ text or add ^superscript^.

## Lists

Unordered list:
* Item 1
* Item 2
* Item 3

Ordered list:
1. First item
2. Second item
3. Third item

## Links and Images

Here's a [link to Reddit](https://www.reddit.com).

And here's an image:
![Reddit Logo](https://www.redditstatic.com/desktop2x/img/favicon/android-icon-192x192.png)

## Blockquotes

> This is a blockquote.
> It can span multiple lines.

## Code

Inline code: `console.log("Hello, world!");`

Code block:
\```
function greet(name) {
    return "Hello, " + name + "!";
}
\```
{{/markdown}}
HTML;

// Create a component with static Markdown content
$staticMarkdownContent = DivComponent::render([
    'id' => 'static-markdown-content',
    'content' => $markdown_text
]);

// Create a component for dynamic Markdown content
$dynamicMarkdownContent = DivComponent::render([
    'id' => 'dynamic-markdown-content',
    'hx-get' => '/api/get-markdown',
    'hx-trigger' => 'load',
    'hx-target' => '#dynamic-markdown-content',
    'content' => '# Loading dynamic Markdown...'
], []);

// Render the template
$html = $engine->render('markdown_plugin_example.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'static_markdown_content' => $staticMarkdownContent,
    'dynamic_markdown_content' => $dynamicMarkdownContent,
]);

// Apply HTMX plugins (including the MarkdownPlugin)
$html = $pluginManager->applyHtmxPlugins($html);

echo $html;