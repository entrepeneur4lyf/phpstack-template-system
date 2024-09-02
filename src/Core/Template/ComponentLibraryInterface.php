<?php

declare(strict_types=1);

namespace phpStack\Core\Template;

/**
 * Class ComponentLibraryInterface
 *
 * Provides an interface for rendering and previewing components.
 */
class ComponentLibraryInterface
{
    private TemplateEngine $templateEngine;
    private ComponentLibrary $componentLibrary;

    public function __construct(TemplateEngine $templateEngine, ComponentLibrary $componentLibrary)
    {
        $this->templateEngine = $templateEngine;
        $this->componentLibrary = $componentLibrary;
    }

    public function renderInterface(): string
    {
        $components = $this->componentLibrary->getAvailableComponents();
        return $this->templateEngine->render('component_library.htmx', [
            'components' => $components,
        ]);
    }

    public function renderComponentPreview(string $componentName): string
    {
        $component = $this->componentLibrary->getComponent($componentName);

        if ($component === null) {
            throw new \RuntimeException("Component not found: $componentName");
        }

        $renderedComponent = call_user_func($component['render']);
        $styles = $component['style'] ?? '';
        $scripts = $component['script'] ?? '';

        return $this->templateEngine->render('component_preview.htmx', [
            'componentName' => $componentName,
            'componentCode' => $renderedComponent,
            'styles' => $styles,
            'scripts' => $scripts,
        ]);
    }
}
