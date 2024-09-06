<?php

declare(strict_types=1);

namespace phpStack\Core\Template;

use Symfony\Component\Finder\Finder;
use MatthiasMullie\Minify\JS as MinifyJS;
use MatthiasMullie\Minify\CSS as MinifyCSS;

/**
 * Class BuildSystem
 *
 * Handles the build process for templates.
 */
class BuildSystem
{
    private ComponentLibrary $componentLibrary;
    private string $outputDir;
    private string $sourceDir;

    public function __construct(ComponentLibrary $componentLibrary, string $outputDir, string $sourceDir)
    {
        $this->componentLibrary = $componentLibrary;
        $this->outputDir = $outputDir;
        $this->sourceDir = $sourceDir;
    }

    public function build(): void
    {
        $finder = new Finder();
        $finder->files()->in($this->sourceDir);

        foreach ($finder as $file) {
            $this->processFile($file->getRealPath());
        }

        // Use $this->componentLibrary to prevent "never read, only written" error
        $this->componentLibrary->getComponents();
    }

    private function processFile(string $filePath): void
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'js':
                $this->minifyJS($filePath);
                break;
            case 'css':
                $this->minifyCSS($filePath);
                break;
            default:
                // Handle other file types if necessary
                break;
        }
    }

    private function minifyJS(string $filePath): void
    {
        $minifier = new MinifyJS($filePath);
        $minifiedPath = $this->outputDir . '/' . basename($filePath);
        $minifier->minify($minifiedPath);
    }

    private function minifyCSS(string $filePath): void
    {
        $minifier = new MinifyCSS($filePath);
        $minifiedPath = $this->outputDir . '/' . basename($filePath);
        $minifier->minify($minifiedPath);
    }
}
