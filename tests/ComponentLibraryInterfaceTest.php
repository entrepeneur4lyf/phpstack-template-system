<?php

declare(strict_types=1);

namespace phpStack\Tests;

use phpStack\Core\Template\ComponentLibrary;
use phpStack\Core\Template\ComponentLibraryInterface;
use phpStack\Core\Template\TemplateEngine;
use PHPUnit\Framework\TestCase;

class ComponentLibraryInterfaceTest extends TestCase
{
    public function testRenderComponentPreview(): void
    {
        $templateEngine = $this->createMock(TemplateEngine::class);
        $componentLibrary = $this->createMock(ComponentLibrary::class);

        $componentName = 'testComponent';
        $componentCode = '<div>Test Component</div>';
        $styles = 'body { background-color: #f0f0f0; }';
        $scripts = 'console.log("Test Component Loaded");';
        $componentArgs = ['arg1' => 'value1', 'arg2' => 'value2'];

        $component = [
            'render' => fn() => $componentCode,
            'style' => $styles,
            'script' => $scripts,
            'args' => $componentArgs,
        ];

        $componentLibrary->method('getComponent')->with($componentName)->willReturn($component);

        $templateEngine->method('render')->with('component_preview.htmx', [
            'componentName' => $componentName,
            'componentCode' => $componentCode,
            'styles' => $styles,
            'scripts' => $scripts,
            'componentArgs' => $componentArgs,
        ])->willReturn('Rendered Template');

        $componentLibraryInterface = new ComponentLibraryInterface($templateEngine, $componentLibrary);
        $result = $componentLibraryInterface->renderComponentPreview($componentName);

        $this->assertEquals('Rendered Template', $result);
    }
}