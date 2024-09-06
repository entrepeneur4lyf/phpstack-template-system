<?php

namespace phpStack\TemplateSystem\Core\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;

class ForeachPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $array = $args['array'] ?? [];
        $body = $args['body'] ?? '';
        $result = '';

        // Ensure $array is an array or Traversable
        if (!is_array($array) && !($array instanceof \Traversable)) {
            throw new \RuntimeException("Foreach plugin requires 'array' to be an array or Traversable");
        }

        // Iterate over the array and replace placeholders with actual key and value
        foreach ($array as $key => $value) {
            $itemBody = str_replace(['{key}', '{value}'], [$key, $value], $body);
            $result .= $itemBody;
        }

        return $result;
    }

    public function getDependencies(): array
    {
        return [];
    }

    public function applyToComponent(string $name, array $options): string
    {
        return '';
    }
}
