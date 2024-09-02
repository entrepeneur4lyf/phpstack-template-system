<?php

namespace phpStack\TemplateSystem\Tests\Unit\Core\Plugins;

use phpStack\TemplateSystem\Core\Plugins\PluginManager;
use phpStack\TemplateSystem\Core\Template\PluginInterface;
use PHPUnit\Framework\TestCase;

class PluginManagerTest extends TestCase
{
    private $pluginManager;

    protected function setUp(): void
    {
        $this->pluginManager = new PluginManager();
    }

    public function testRegisterAndGetPlugin()
    {
        $mockPlugin = $this->createMock(PluginInterface::class);
        $this->pluginManager->registerPlugin('test-plugin', $mockPlugin, '1.0');

        $this->assertTrue($this->pluginManager->hasPlugin('test-plugin'));
        $this->assertSame($mockPlugin, $this->pluginManager->getPlugin('test-plugin'));
    }

    public function testUpdatePlugin()
    {
        $mockPlugin1 = $this->createMock(PluginInterface::class);
        $mockPlugin2 = $this->createMock(PluginInterface::class);

        $this->pluginManager->registerPlugin('test-plugin', $mockPlugin1, '1.0');
        $this->pluginManager->updatePlugin('test-plugin', $mockPlugin2, '2.0');

        $this->assertSame($mockPlugin2, $this->pluginManager->getPlugin('test-plugin'));
    }

    public function testResolveConflicts()
    {
        $mockPlugin1 = $this->createMock(PluginInterface::class);
        $mockPlugin2 = $this->createMock(PluginInterface::class);
        $mockPlugin3 = $this->createMock(PluginInterface::class);

        $this->pluginManager->registerPlugin('plugin1', $mockPlugin1, '1.0');
        $this->pluginManager->registerPlugin('plugin2', $mockPlugin2, '2.0');
        $this->pluginManager->registerPlugin('plugin3', $mockPlugin3, '1.5');

        $conflicts = [
            [
                'plugins' => ['plugin1', 'plugin2'],
                'resolution' => 'version'
            ]
        ];

        $this->pluginManager->resolveConflicts($conflicts);

        $enabledPlugins = $this->pluginManager->getAll();
        $this->assertArrayHasKey('plugin2', $enabledPlugins);
        $this->assertArrayNotHasKey('plugin1', $enabledPlugins);
    }
}