<?php

namespace phpStack\TemplateSystem\Core\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;

class WhilePlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $condition = $args['condition'] ?? false;
        $body = $args['body'] ?? '';
        $result = '';

        while ($condition) {
            $result .= $body;
            $condition = $args['condition'] ?? false;
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
