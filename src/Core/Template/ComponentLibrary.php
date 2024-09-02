<?php

declare(strict_types=1);

namespace phpStack\Core\Template;

use phpStack\Core\Template\TemplateEngine;
use phpStack\Core\Exceptions\ComponentNotFoundException;

/**
 * Class ComponentLibrary
 *
 * A library of reusable components for templates.
 */
class ComponentLibrary
{
    private TemplateEngine $templateEngine;
    private array $componentDirectories;
    private array $components;
    private array $externalComponents;

    /**
     * ComponentLibrary constructor.
     *
     * @param TemplateEngine $templateEngine The template engine instance.
     * @param array $componentDirectories The directories to search for components.
     */
    public function __construct(TemplateEngine $templateEngine, array $componentDirectories = [])
    {
        $this->templateEngine = $templateEngine;
        $this->componentDirectories = $componentDirectories;
        $this->components = [];
        $this->externalComponents = [];
    }

    public function addComponentDirectory(string $directory): void
    {
        $this->componentDirectories[] = $directory;
    }

    public function loadComponents(): void
    {
        foreach ($this->componentDirectories as $directory) {
            $this->loadComponentsFromDirectory($directory);
        }
        $this->loadExternalComponents();
    }

    private function loadComponentsFromDirectory(string $directory): void
    {
        $files = glob($directory . '/*.php');
        foreach ($files as $file) {
            $componentName = basename($file, '.php');
            $componentData = include $file;
            
            if (is_array($componentData) && isset($componentData['render'])) {
                $this->components[$componentName] = $componentData;
                $this->templateEngine->registerComponent(
                    $componentName,
                    $componentData['render'],
                    $componentData['style'] ?? null,
                    $componentData['script'] ?? null,
                    $componentData['events'] ?? [],
                    $componentData['dependencies'] ?? []
                );
            }
        }
    }

    private function loadExternalComponents(): void
    {
        $composerClassLoader = require __DIR__ . '/../../../../vendor/autoload.php';
        $prefixes = $composerClassLoader->getPrefixesPsr4();

        foreach ($prefixes as $namespace => $paths) {
            foreach ($paths as $path) {
                $componentDir = $path . '/Components';
                if (is_dir($componentDir)) {
                    $this->loadComponentsFromDirectory($componentDir);
                }
            }
        }
    }

    public function getAvailableComponents(): array
    {
        return array_keys($this->components);
    }

    public function getComponent(string $componentName): ?array
    {
        return $this->components[$componentName] ?? null;
    }

    public function loadOptimizedComponents(string $optimizedDir): void
    {
        $this->components = [];
        $this->loadComponentsFromDirectory($optimizedDir);

        // Load bundled assets
        $bundledJs = file_get_contents($optimizedDir . '/bundle.js');
        $bundledCss = file_get_contents($optimizedDir . '/bundle.css');

        // Register bundled assets with the template engine
        $this->templateEngine->registerGlobalAssets($bundledCss, $bundledJs);
    }
}
