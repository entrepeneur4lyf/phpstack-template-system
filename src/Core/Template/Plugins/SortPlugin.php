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

        $items = $this->getItemsArray($input, $data);

        if (!is_array($items) && !($items instanceof \Traversable)) {
            throw new \RuntimeException("Sort plugin input must be an array or Traversable");
        }

        $items = is_array($items) ? $items : iterator_to_array($items);

        if ($by !== null) {
            usort($items, function($a, $b) use ($by, $order, $data) {
                $aVal = $this->getValueByPath($a, $by, $data);
                $bVal = $this->getValueByPath($b, $by, $data);
                return $order === 'asc' ? $this->compare($aVal, $bVal) : $this->compare($bVal, $aVal);
            });
        } else {
            $order === 'asc' ? sort($items) : rsort($items);
        }

        return $items;
    }

    private function getItemsArray($items, array $data)
    {
        if (is_string($items) && isset($data[$items])) {
            return $data[$items];
        }
        if ($items instanceof \Traversable) {
            return iterator_to_array($items);
        }
        return is_array($items) ? $items : [];
    }

    private function getValueByPath($item, $path, array $data)
    {
        if (is_callable($path)) {
            return $path($item, $data);
        }

        $value = $item;
        foreach (explode('.', $path) as $segment) {
            if (is_array($value) && isset($value[$segment])) {
                $value = $value[$segment];
            } elseif (is_object($value) && isset($value->$segment)) {
                $value = $value->$segment;
            } else {
                return null;
            }
        }
        return $value;
    }

    private function compare($a, $b)
    {
        if (is_numeric($a) && is_numeric($b)) {
            return $a <=> $b;
        }
        return strcasecmp((string)$a, (string)$b);
    }
}
