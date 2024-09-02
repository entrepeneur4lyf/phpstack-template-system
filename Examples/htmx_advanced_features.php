<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use phpStack\TemplateSystem\Core\Template\FormComponent;
use phpStack\TemplateSystem\Core\Template\InputComponent;
use phpStack\TemplateSystem\Core\Template\ButtonComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;
use phpStack\TemplateSystem\Core\Template\InfiniteScrollComponent;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginManager;

// Initialize TemplateEngine and HTMX integration
$engine = new TemplateEngine('Examples/templates');
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create HtmxViewHelper
$htmxHelper = new HtmxViewHelper($config);

// Configure HTMX
$config->set('defaultSwapStyle', 'outerHTML');
$config->set('includeIndicatorStyles', true);

// Create a custom HTMX plugin
class CustomHtmxPlugin implements HtmxPluginInterface
{
    public function processHtmxContent(string $content): string
    {
        return str_replace('{{current_time}}', date('Y-m-d H:i:s'), $content);
    }

    public function execute(array $args, array $data) { /* ... */ }
    public function getDependencies(): array { return []; }
    public function applyToComponent(string $name, array $options): string { return ''; }
}

$pluginManager = new HtmxPluginManager();
$pluginManager->registerHtmxPlugin('custom-time-plugin', new CustomHtmxPlugin(), '1.0.0');

// Create components
$searchForm = FormComponent::render([
    'hx-post' => '/api/search',
    'hx-target' => '#search-results',
    'hx-indicator' => '.htmx-indicator',
    'content' => InputComponent::render([
        'type' => 'text',
        'name' => 'query',
        'placeholder' => 'Search...',
        'hx-trigger' => 'keyup changed delay:500ms'
    ], [])
], []);

$searchResults = DivComponent::render([
    'id' => 'search-results',
    'content' => '<p>Type to search...</p>'
], []);

$infiniteScroll = InfiniteScrollComponent::render([
    'url' => '/api/more-content',
    'target' => '#content-list'
], []);

$contentList = DivComponent::render([
    'id' => 'content-list',
    'content' => '<div>Initial content</div>'
], []);

$timeButton = ButtonComponent::render([
    'text' => 'Get Current Time',
    'hx-get' => '/api/time',
    'hx-target' => '#time-display'
], []);

$timeDisplay = DivComponent::render([
    'id' => 'time-display',
    'content' => '{{current_time}}'
], []);

// Render the template
$html = $engine->render('htmx_advanced_features.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'search_form' => $searchForm,
    'search_results' => $searchResults,
    'infinite_scroll' => $infiniteScroll,
    'content_list' => $contentList,
    'time_button' => $timeButton,
    'time_display' => $timeDisplay,
]);

// Apply HTMX plugins
$html = $pluginManager->applyHtmxPlugins($html);

echo $html;