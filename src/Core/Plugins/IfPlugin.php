<?php

namespace phpStack\TemplateSystem\Core\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;

class IfPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $condition = $args['condition'] ?? false;
        $then = $args['then'] ?? '';
        $else = $args['else'] ?? '';

        return $condition ? $then : $else;
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
