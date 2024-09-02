<?php

namespace phpStack\Core\Template;

use MatthiasMullie\Minify;
use Symfony\Component\Finder\Finder;

/**
 * Class BuildSystem
 *
 * Handles the build process for templates.
 */
class BuildSystem
{
    private $componentLibrary;
    private $outputDir;
    private $sourceDir;

    public function __construct(ComponentLibrary $componentLibrary, string $outputDir, string $sourceDir)
    {
        $this->componentLibrary = $componentLibrary;
        $this->outputDir = $outputDir;
        $this->sourceDir = $sourceDir;
    }

    public function build(): void
    {
        $components = $this->componentLibrary->getAvailableComponents();
        $bundledJs = '';
        $bundledCss = '';

        foreach ($components as $componentName) {
            $component = $this->componentLibrary->getComponent($componentName);
            
            if ($component['script']) {
                $bundledJs .= $this->minifyJs($component['script']);
            }
            
            if ($component['style']) {
                $bundledCss .= $this->minifyCss($component['style']);
            }

            // Save the optimized component
            $this->saveOptimizedComponent($componentName, $component);
        }

        // Save bundled and minified assets
        $this->saveBundledAssets($bundledJs, $bundledCss);
    }

    public function watch(): void
    {
        echo "Watching for file changes. Press Ctrl+C to stop.\n";

        $lastBuildTime = time();

        while (true) {
            $finder = new Finder();
            $finder->files()->in($this->sourceDir)->name('*.php');

            foreach ($finder as $file) {
                if ($file->getMTime() > $lastBuildTime) {
                    echo "Changes detected. Rebuilding...\n";
                    $this->build();
                    $lastBuildTime = time();
                    break;
                }
            }

            sleep(1);
        }
    }

    private function minifyJs(string $js): string
    {
        $minifier = new Minify\JS($js);
        return $minifier->minify();
    }

    private function minifyCss(string $css): string
    {
        $minifier = new Minify\CSS($css);
        return $minifier->minify();
    }

    private function saveOptimizedComponent(string $componentName, array $component): void
    {
        $optimizedComponent = [
            'render' => $component['render'],
            // Remove individual style and script as they are now bundled
            'dependencies' => $component['dependencies'] ?? []
        ];

        $filename = $this->outputDir . '/' . $componentName . '.php';
        file_put_contents($filename, '<?php return ' . var_export($optimizedComponent, true) . ';');
    }

    private function saveBundledAssets(string $js, string $css): void
    {
        file_put_contents($this->outputDir . '/bundle.js', $js);
        file_put_contents($this->outputDir . '/bundle.css', $css);
    }
}
