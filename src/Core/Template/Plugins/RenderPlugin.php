<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;
use phpStack\Core\Template\TemplateEngine;

class RenderPlugin implements PluginInterface
{
    private $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

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