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

// Initialize TemplateEngine and HTMX integration
$engine = new TemplateEngine('Examples/templates');
$config = new HtmxConfig();
HtmxComponents::registerAll($engine, $config);

// Create HtmxViewHelper
$htmxHelper = new HtmxViewHelper($config);

// Configure HTMX
$config->set('defaultSwapStyle', 'outerHTML');
$config->set('includeIndicatorStyles', true);

// Live search with infinite scroll
$searchInput = InputComponent::render([
    'type' => 'text',
    'name' => 'search',
    'placeholder' => 'Search...',
    'hx-post' => '/api/search',
    'hx-trigger' => 'keyup changed delay:500ms, search',
    'hx-target' => '#search-results',
    'hx-indicator' => '.htmx-indicator'
], []);

$searchResults = DivComponent::render([
    'id' => 'search-results',
    'hx-trigger' => 'revealed',
    'hx-get' => '/api/search?page=${next}',
    'hx-swap' => 'beforeend',
    'hx-indicator' => '.htmx-indicator',
    'content' => '<p>Type to search...</p>'
], []);

// Modal with form
$modalTrigger = ButtonComponent::render([
    'text' => 'Open Modal',
    'hx-get' => '/api/modal',
    'hx-target' => '#modal',
    'hx-trigger' => 'click'
], []);

$modal = DivComponent::render([
    'id' => 'modal',
    'style' => 'display:none;',
    'content' => ''
], []);

// WebSocket chat
$chatMessages = DivComponent::render([
    'id' => 'chat-messages',
    'hx-ws' => 'connect:wss://example.com/chat',
    'content' => ''
], []);

$chatInput = FormComponent::render([
    'hx-ws' => 'send',
    'content' => '
        <input type="text" name="message" placeholder="Type a message...">
        <button type="submit">Send</button>
    '
], []);

// Render the template
$html = $engine->render('htmx_complex_example.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'search_input' => $searchInput,
    'search_results' => $searchResults,
    'modal_trigger' => $modalTrigger,
    'modal' => $modal,
    'chat_messages' => $chatMessages,
    'chat_input' => $chatInput,
]);

echo $html;