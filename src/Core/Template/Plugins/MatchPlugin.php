<?php

namespace phpStack\TemplateSystem\Core\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;

class MatchPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $value = $args['value'] ?? null;
        $cases = $args['cases'] ?? [];
        $default = $args['default'] ?? '';

        return $cases[$value] ?? $default;
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
