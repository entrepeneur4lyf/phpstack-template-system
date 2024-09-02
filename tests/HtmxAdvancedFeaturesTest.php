<?php

use PHPUnit\Framework\TestCase;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\HtmxViewHelper;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginManager;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginInterface;

class HtmxAdvancedFeaturesTest extends TestCase
{
    private $engine;
    private $config;
    private $htmxHelper;
    private $pluginManager;

    protected function setUp(): void
    {
        $this->engine = new TemplateEngine();
        $this->config = new HtmxConfig();
        HtmxComponents::registerAll($this->engine, $this->config);
        $this->htmxHelper = new HtmxViewHelper($this->config);
        $this->pluginManager = new HtmxPluginManager();
    }

    public function testHtmxViewHelper()
    {
        $script = $this->htmxHelper->renderHtmxScript();
        $this->assertStringContainsString('<script src="https://unpkg.com/htmx.org@1.9.2"></script>', $script);

        $config = $this->htmxHelper->renderHtmxConfig();
        $this->assertStringContainsString('<script>htmx.config = ', $config);
    }

    public function testCustomHtmxPlugin()
    {
        $customPlugin = new class implements HtmxPluginInterface {
            public function processHtmxContent(string $content): string
            {
                return str_replace('{{test}}', 'Plugin works!', $content);
            }
            public function execute(array $args, array $data) { }
            public function getDependencies(): array { return []; }
            public function applyToComponent(string $name, array $options): string { return ''; }
        };

        $this->pluginManager->registerHtmxPlugin('test-plugin', $customPlugin, '1.0.0');

        $content = '<div>{{test}}</div>';
        $processedContent = $this->pluginManager->applyHtmxPlugins($content);

        $this->assertEquals('<div>Plugin works!</div>', $processedContent);
    }

    public function testInfiniteScrollComponent()
    {
        $infiniteScroll = InfiniteScrollComponent::render([
            'url' => '/api/more-content',
            'target' => '#content-list'
        ], []);

        $this->assertStringContainsString('hx-trigger="revealed"', $infiniteScroll);
        $this->assertStringContainsString('hx-get="/api/more-content"', $infiniteScroll);
        $this->assertStringContainsString('hx-target="#content-list"', $infiniteScroll);
    }

    public function testHtmxIndicator()
    {
        $form = FormComponent::render([
            'hx-post' => '/api/search',
            'hx-target' => '#search-results',
            'hx-indicator' => '.htmx-indicator',
            'content' => 'Search form'
        ], []);

        $this->assertStringContainsString('hx-indicator=".htmx-indicator"', $form);
    }
}