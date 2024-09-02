<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;

class IncludePlugin implements PluginInterface
{
    private $templateDir;

    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function execute(array $args, array $data)
    {
        $templateFile = $args['file'] ?? null;
        if ($templateFile === null) {
            throw new \RuntimeException("Include plugin requires a 'file' argument");
        }

        $fullPath = $this->templateDir . '/' . $templateFile;
        if (!file_exists($fullPath)) {
            throw new \RuntimeException("Template file not found: $fullPath");
        }

        return file_get_contents($fullPath);
    }
}