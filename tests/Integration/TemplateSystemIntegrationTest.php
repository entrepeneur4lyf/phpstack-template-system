<?php

namespace phpStack\TemplateSystem\Tests\Integration;

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use phpStack\TemplateSystem\Core\Template\HtmxComponents;
use phpStack\TemplateSystem\Core\Template\HtmxConfig;
use phpStack\TemplateSystem\Core\Plugins\PluginManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class TemplateSystemIntegrationTest extends TestCase
{
    private $templateEngine;
    private $pluginManager;

    protected function setUp(): void
    {
        $templateDir = __DIR__ . '/templates';
        if (!is_dir($templateDir)) {
            mkdir($templateDir, 0777, true);
        }

        $profiler = new PerformanceProfiler();
        $cache = new ArrayAdapter();

        $this->templateEngine = new TemplateEngine($templateDir, $profiler, $cache);
        $this->pluginManager = new PluginManager();

        HtmxComponents::registerAll($this->templateEngine, new HtmxConfig());
    }

    public function testFullSystemIntegration()
    {
        // Register a custom component
        $this->templateEngine->registerComponent('greeting', function($args, $data) {
            return "<h1>Hello, {$data['name']}!</h1>";
        });

        // Register a custom plugin
        $this->pluginManager->registerPlugin('uppercase', new class implements \phpStack\TemplateSystem\Core\Template\PluginInterface {
            public function execute(array $args, array $data) {
                return strtoupper($args['text']);
            }
            public function getDependencies(): array {
                return [];
            }
        }, '1.0');

        // Create a test template
        $templateContent = '
            <?php echo $this->renderComponent("greeting", ["name" => $name]); ?>
            <p><?php echo $this->executePlugin("uppercase", ["text" => $message]); ?></p>
            <?php echo HtmxComponents::ButtonComponent::render([
                "text" => "Click me",
                "hx-post" => "/api/greet",
                "hx-target" => "#greeting"
            ]); ?>
        ';
        file_put_contents(__DIR__ . '/templates/test_integration.php', $templateContent);

        // Render the template
        $result = $this->templateEngine->render('test_integration.php', [
            'name' => 'World',
            'message' => 'This is a test message.'
        ]);

        // Assertions
        $this->assertStringContainsString('<h1>Hello, World!</h1>', $result);
        $this->assertStringContainsString('<p>THIS IS A TEST MESSAGE.</p>', $result);
        $this->assertStringContainsString('<button', $result);
        $this->assertStringContainsString('hx-post="/api/greet"', $result);
        $this->assertStringContainsString('hx-target="#greeting"', $result);

        // Clean up
        unlink(__DIR__ . '/templates/test_integration.php');
    }
}