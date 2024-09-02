<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;
use phpStack\Core\Template\TemplateEngine;

/**
 * RenderPlugin class for rendering template files with custom data.
 */
class RenderPlugin implements PluginInterface
{
    /** @var TemplateEngine */
    private $templateEngine;

    /**
     * RenderPlugin constructor.
     *
     * @param TemplateEngine $templateEngine The template engine instance
     */
    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * Execute the render plugin.
     *
     * @param array $args Arguments passed to the plugin
     * @param array $data Data context for the plugin execution
     * @return string The rendered template content
     * @throws \RuntimeException If the file argument is missing
     */
    public function execute(array $args, array $data)
    {
        $templateFile = $args['file'] ?? null;
        if ($templateFile === null) {
            throw new \RuntimeException("Render plugin requires a 'file' argument");
        }

        $componentData = $args['data'] ?? [];
        if (is_string($componentData)) {
            $componentData = $this->parseDataString($componentData, $data);
        }

        return $this->templateEngine->render($templateFile, $componentData + $data);
    }

    /**
     * Parse a data string into an associative array.
     *
     * @param string $dataString The data string to parse
     * @param array $context The context array for variable resolution
     * @return array The parsed data as an associative array
     */
    private function parseDataString(string $dataString, array $context): array
    {
        $result = [];
        $pairs = explode(',', $dataString);
        foreach ($pairs as $pair) {
            list($key, $value) = explode('=', $pair, 2);
            $key = trim($key);
            $value = trim($value);
            if (strpos($value, '$') === 0) {
                $varName = substr($value, 1);
                $value = $context[$varName] ?? null;
            }
            $result[$key] = $value;
        }
        return $result;
    }
}
