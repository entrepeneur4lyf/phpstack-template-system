<?php

use PHPUnit\Framework\TestCase;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\ButtonComponent;
use phpStack\TemplateSystem\Core\Template\FormComponent;
use phpStack\TemplateSystem\Core\Template\InfiniteScrollComponent;

class HtmxCompatibilityTest extends TestCase
{
    private $engine;
    private $config;

    protected function setUp(): void
    {
        $this->engine = new TemplateEngine();
        $this->config = new HtmxConfig();
        HtmxComponents::registerAll($this->engine, $this->config);
    }

    /**
     * @dataProvider htmxVersionProvider
     */
    public function testCompatibilityWithHtmxVersions($version)
    {
        $button = ButtonComponent::render([
            'text' => 'Click me',
            'hx-post' => '/api/endpoint',
            'hx-target' => '#result'
        ], []);

        $this->assertStringContainsString('hx-post="/api/endpoint"', $button);
        $this->assertStringContainsString('hx-target="#result"', $button);

        $form = FormComponent::render([
            'hx-post' => '/api/submit',
            'hx-swap' => 'outerHTML',
            'content' => '<input type="text" name="username">'
        ], []);

        $this->assertStringContainsString('hx-post="/api/submit"', $form);
        $this->assertStringContainsString('hx-swap="outerHTML"', $form);

        $infiniteScroll = InfiniteScrollComponent::render([
            'url' => '/api/more-content',
            'target' => '#content-list'
        ], []);

        $this->assertStringContainsString('hx-trigger="revealed"', $infiniteScroll);
        $this->assertStringContainsString('hx-get="/api/more-content"', $infiniteScroll);
        $this->assertStringContainsString('hx-target="#content-list"', $infiniteScroll);
    }

    public function htmxVersionProvider()
    {
        return [
            ['1.8.0'],
            ['1.8.5'],
            ['1.9.0'],
            ['1.9.2'],
            ['1.9.3'],
            ['1.9.4'],
        ];
    }

    public function testConfigurationCompatibility()
    {
        $this->config->set('historyEnabled', false);
        $this->assertEquals(false, $this->config->get('historyEnabled'));

        $this->config->set('defaultSwapStyle', 'outerHTML');
        $this->assertEquals('outerHTML', $this->config->get('defaultSwapStyle'));

        $this->config->set('selfRequestsOnly', true);
        $this->assertEquals(true, $this->config->get('selfRequestsOnly'));
    }
}