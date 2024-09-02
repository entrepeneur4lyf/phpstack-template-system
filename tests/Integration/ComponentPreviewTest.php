<?php

declare(strict_types=1);

namespace phpStack\Tests\Integration;

use phpStack\Core\Template\ComponentLibrary;
use phpStack\Core\Template\ComponentLibraryInterface;
use phpStack\Core\Template\TemplateEngine;
use PHPUnit\Framework\TestCase;

class ComponentPreviewTest extends TestCase
{
    public function testComponentPreview(): void
    {
        $templateEngine = new TemplateEngine();
        $componentLibrary = new ComponentLibrary($templateEngine, ['/path/to/components']);

        // Register a test component
        $componentLibrary->registerComponent('testComponent', [
            'render' => fn() => '<div>Test Component</div>',
            'style' => 'body { background-color: #f0f0f0; }',
            'script' => 'console.log("Test Component Loaded");',
            'args' => ['arg1' => 'value1', 'arg2' => 'value2'],
        ]);

        $componentLibraryInterface = new ComponentLibraryInterface($templateEngine, $componentLibrary);
        $result = $componentLibraryInterface->renderComponentPreview('testComponent');

        $this->assertStringContainsString('<div>Test Component</div>', $result);
        $this->assertStringContainsString('body { background-color: #f0f0f0; }', $result);
        $this->assertStringContainsString('console.log("Test Component Loaded");', $result);
    }
}