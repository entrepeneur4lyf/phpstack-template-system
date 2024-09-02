<?php

namespace phpStack\Core\Template;

class ComponentLibraryInterface
{
    private $templateEngine;
    private $componentLibrary;

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
        // This is a simple preview. You might want to add more sophisticated preview logic.
        return $this->templateEngine->render('component_preview.htmx', [
            'componentName' => $componentName,
            'componentCode' => "Component preview for {$componentName}",
        ]);
    }
}