<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;

/**
 * IncludePlugin class for including external template files.
 */
class IncludePlugin implements PluginInterface
{
    /** @var string */
    private $templateDir;

    /**
     * IncludePlugin constructor.
     *
     * @param string $templateDir The directory containing template files
     */
    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    /**
     * Execute the include plugin.
     *
     * @param array $args Arguments passed to the plugin
     * @param array $data Data context for the plugin execution
     * @return string The contents of the included file
     * @throws \RuntimeException If the file argument is missing or the file is not found
     */
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
