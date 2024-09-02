<?php

namespace phpStack\TemplateSystem\Tests\Unit\Core\Template;

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class TemplateEngineTest extends TestCase
{
    private $templateEngine;
    private $mockProfiler;
    private $mockCache;

    protected function setUp(): void
    {
        $this->mockProfiler = $this->createMock(PerformanceProfiler::class);
        $this->mockCache = $this->createMock(CacheItemPoolInterface::class);
        $this->templateEngine = new TemplateEngine(__DIR__ . '/templates', $this->mockProfiler, $this->mockCache);
    }

    public function testRenderTemplate()
    {
        $templateContent = '<?php echo "Hello, " . $name; ?>';
        file_put_contents(__DIR__ . '/templates/test.php', $templateContent);

        $mockCacheItem = $this->createMock(CacheItemInterface::class);
        $mockCacheItem->method('isHit')->willReturn(false);
        $this->mockCache->method('getItem')->willReturn($mockCacheItem);

        $result = $this->templateEngine->render('test.php', ['name' => 'World']);
        $this->assertEquals('Hello, World', $result);

        unlink(__DIR__ . '/templates/test.php');
    }

    public function testRegisterComponent()
    {
        $componentFunction = function($args, $data) {
            return "<div>{$data['content']}</div>";
        };

        $this->templateEngine->registerComponent('test-component', $componentFunction);

        $templateContent = '<?php echo $this->renderComponent("test-component", ["content" => "Test"]); ?>';
        file_put_contents(__DIR__ . '/templates/component_test.php', $templateContent);

        $mockCacheItem = $this->createMock(CacheItemInterface::class);
        $mockCacheItem->method('isHit')->willReturn(false);
        $this->mockCache->method('getItem')->willReturn($mockCacheItem);

        $result = $this->templateEngine->render('component_test.php', []);
        $this->assertEquals('<div>Test</div>', $result);

        unlink(__DIR__ . '/templates/component_test.php');
    }
}