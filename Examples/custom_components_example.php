<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use Examples\Components\CustomSearchComponent;
use Examples\Components\InfiniteScrollListComponent;

// Initialize TemplateEngine and HTMX integration
$engine = new TemplateEngine('Examples/templates');
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create HtmxViewHelper
$htmxHelper = new HtmxViewHelper($config);

// Create custom components
$customSearch = CustomSearchComponent::render([
    'placeholder' => 'Search products...',
    'endpoint' => '/api/product-search'
], []);

$infiniteScrollList = InfiniteScrollListComponent::render([
    'id' => 'product-list',
    'endpoint' => '/api/more-products',
    'initial_content' => '<div>Initial product list...</div>'
], []);

// Render the template
$html = $engine->render('custom_components_example.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'custom_search' => $customSearch,
    'infinite_scroll_list' => $infiniteScrollList,
]);

echo $html;