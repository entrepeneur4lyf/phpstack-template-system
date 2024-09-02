<?php

namespace phpStack\TemplateSystem\Core\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;

class ForPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $start = $args['start'] ?? 0;
        $end = $args['end'] ?? 0;
        $step = $args['step'] ?? 1;
        $body = $args['body'] ?? '';
        $result = '';

        for ($i = $start; $i < $end; $i += $step) {
            $result .= str_replace('{i}', $i, $body);
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
