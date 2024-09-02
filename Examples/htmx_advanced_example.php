<?php

require_once 'vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use phpStack\TemplateSystem\Core\Template\FormComponent;
use phpStack\TemplateSystem\Core\Template\ButtonComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;
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

// Create components
$tabsContainer = DivComponent::render([
    'id' => 'tabs-container',
    'hx-target' => '#tab-content',
    'hx-trigger' => 'click',
    'content' => '
        <button hx-get="/api/tab1">Tab 1</button>
        <button hx-get="/api/tab2">Tab 2</button>
        <button hx-get="/api/tab3">Tab 3</button>
    '
], []);

$tabContent = DivComponent::render([
    'id' => 'tab-content',
    'content' => '<p>Click a tab to load content</p>'
], []);

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

$sseDiv = DivComponent::render([
    'hx-ext' => 'sse',
    'sse-connect' => '/api/sse',
    'sse-swap' => 'message',
    'content' => '<p>Waiting for SSE updates...</p>'
], []);

$wsChat = FormComponent::render([
    'hx-ext' => 'ws',
    'ws-connect' => '/api/ws-chat',
    'content' => '
        <div id="chat-messages"></div>
        <input type="text" name="message" placeholder="Type a message...">
        <button type="submit">Send</button>
    '
], []);

// Render the template
$html = $engine->render('htmx_advanced_example.html', [
    'htmx_script' => $htmxHelper->renderHtmxScript(),
    'htmx_config' => $htmxHelper->renderHtmxConfig(),
    'tabs_container' => $tabsContainer,
    'tab_content' => $tabContent,
    'modal_trigger' => $modalTrigger,
    'modal' => $modal,
    'sse_div' => $sseDiv,
    'ws_chat' => $wsChat,
]);

echo $html;