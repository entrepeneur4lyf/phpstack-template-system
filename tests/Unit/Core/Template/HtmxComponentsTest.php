<?php

namespace phpStack\TemplateSystem\Tests\Unit\Core\Template;

use PHPUnit\Framework\TestCase;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;

class HtmxComponentsTest extends TestCase
{
    public function testRegisterAll()
    {
        $engine = $this->createMock(TemplateEngine::class);
        $config = $this->createMock(HtmxConfig::class);

        $engine->expects($this->atLeastOnce())->method('registerComponent');
        $engine->expects($this->atLeastOnce())->method('registerExtension');
        $engine->expects($this->once())->method('registerRequestHandler');

        HtmxComponents::registerAll($engine, $config);

        $this->assertInstanceOf(HtmxConfig::class, HtmxComponents::getConfig());
    }

    public function testRegisterPlugin()
    {
        $pluginName = 'testPlugin';
        $plugin = function() {};
        $version = '1.0.0';

        HtmxComponents::registerPlugin($pluginName, $plugin, $version);

        $this->assertTrue(HtmxComponents::hasPlugin($pluginName));
    }

    public function testAddHooks()
    {
        $hook = function() {};

        HtmxComponents::addBeforeRequestHook($hook);
        HtmxComponents::addBeforeRenderHook($hook);

        $this->assertContains($hook, HtmxComponents::getBeforeRequestHooks());
        $this->assertContains($hook, HtmxComponents::getBeforeRenderHooks());
    }
}