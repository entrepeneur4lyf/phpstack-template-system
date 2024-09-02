<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use phpStack\TemplateSystem\Core\Template\FormComponent;
use phpStack\TemplateSystem\Core\Template\InputComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;

// Initialize TemplateEngine and HTMX integration
$engine = new TemplateEngine('Examples/templates');
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create HtmxViewHelper
$htmxHelper = new HtmxViewHelper($config);

// Configure HTMX
$config->set('defaultSwapStyle', 'innerHTML');
$config->set('includeIndicatorStyles', true);

// Live search input
$searchInput = InputComponent::render([
    'type' => 'text',
    'name' => 'search',
    'placeholder' => 'Search...',
    'hx-post' => '/api/search',
    'hx-trigger' => 'keyup changed delay:500ms',
    'hx-target' => '#search-results',
    'hx-indicator' => '.htmx-indicator'
], []);

// Search results container
$searchResults = DivComponent::render([
    'id' => 'search-results',
    'content' => '<p>Type to search...</p>'
], []);

// Loading indicator
$loadingIndicator = DivComponent::render([
    'class' => 'htmx-indicator',
    'content' => 'Searching...',
    'style' => 'display:none;'
], []);

// Render the template
$html = $engine->render('htmx_live_search.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'search_input' => $searchInput,
    'loading_indicator' => $loadingIndicator,
    'search_results' => $searchResults,
]);

echo $html;