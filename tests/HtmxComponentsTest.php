<?php

use PHPUnit\Framework\TestCase;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Template\ButtonComponent;
use phpStack\TemplateSystem\Core\Template\FormComponent;
use phpStack\TemplateSystem\Core\Template\InfiniteScrollComponent;

class HtmxComponentsTest extends TestCase
{
    private $engine;
    private $config;

    protected function setUp(): void
    {
        $this->engine = new TemplateEngine();
        $this->config = new HtmxConfig();
        HtmxComponents::registerAll($this->engine, $this->config);
    }

    public function testButtonComponentRendering()
    {
        $button = ButtonComponent::render([
            'text' => 'Click me',
            'hx-post' => '/api/endpoint',
            'hx-target' => '#result'
        ], []);

        $this->assertStringContainsString('Click me', $button);
        $this->assertStringContainsString('hx-post="/api/endpoint"', $button);
        $this->assertStringContainsString('hx-target="#result"', $button);
    }

    public function testFormComponentRendering()
    {
        $form = FormComponent::render([
            'hx-post' => '/api/submit',
            'hx-target' => '#result',
            'content' => '<input type="text" name="username">'
        ], []);

        $this->assertStringContainsString('hx-post="/api/submit"', $form);
        $this->assertStringContainsString('hx-target="#result"', $form);
        $this->assertStringContainsString('<input type="text" name="username">', $form);
    }

    public function testInfiniteScrollComponentRendering()
    {
        $infiniteScroll = InfiniteScrollComponent::render([
            'url' => '/api/more-content',
            'target' => '#content-list'
        ], []);

        $this->assertStringContainsString('hx-trigger="revealed"', $infiniteScroll);
        $this->assertStringContainsString('hx-get="/api/more-content"', $infiniteScroll);
        $this->assertStringContainsString('hx-target="#content-list"', $infiniteScroll);
    }

    public function testConfigurationOptions()
    {
        $this->config->set('historyEnabled', false);
        $this->assertEquals(false, $this->config->get('historyEnabled'));

        $this->config->set('defaultSwapStyle', 'outerHTML');
        $this->assertEquals('outerHTML', $this->config->get('defaultSwapStyle'));
    }

    public function testEventHandlers()
    {
        $called = false;
        HtmxComponents::addBeforeRequestHook(function() use (&$called) {
            $called = true;
        });

        // Simulate triggering the before request hook
        $hooks = $this->getPrivateProperty(HtmxComponents::class, 'beforeRequestHooks');
        foreach ($hooks as $hook) {
            $hook();
        }

        $this->assertTrue($called);
    }

    private function getPrivateProperty($className, $propertyName)
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue();
    }
}