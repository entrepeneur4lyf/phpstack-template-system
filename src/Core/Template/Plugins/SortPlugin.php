<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;

class SortPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $input = $args['input'] ?? null;
        $by = $args['by'] ?? null;
        $order = strtolower($args['order'] ?? 'asc');

        if ($input === null) {
            throw new \RuntimeException("Sort plugin requires an 'input' argument");
        }

        $items = is_string($input) && isset($data[$input]) ? $data[$input] : $input;

        if (!is_array($items)) {
            throw new \RuntimeException("Sort plugin input must be an array");
        }

        if ($by !== null) {
            usort($items, function($a, $b) use ($by, $order) {
                $aVal = is_array($a) ? $a[$by] : $a->$by;
                $bVal = is_array($b) ? $b[$by] : $b->$by;
                return $order === 'asc' ? $aVal <=> $bVal : $bVal <=> $aVal;
            });
        } else {
            $order === 'asc' ? sort($items) : rsort($items);
        }

        return $items;
    }
}