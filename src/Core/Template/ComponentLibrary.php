<?php

namespace phpStack\Core\Template;

use Composer\Autoload\ClassLoader;

class ComponentLibrary
{
    private $templateEngine;
    private $componentDirectories = [];
    private $components = [];
    private $externalComponents = [];

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
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