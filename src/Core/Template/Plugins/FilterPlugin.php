<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;

class FilterPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $input = $args['input'] ?? null;
        $condition = $args['condition'] ?? null;

        if ($input === null || $condition === null) {
            throw new \RuntimeException("Filter plugin requires 'input' and 'condition' arguments");
        }

        $items = is_string($input) && isset($data[$input]) ? $data[$input] : $input;

        if (!is_array($items)) {
            throw new \RuntimeException("Filter plugin input must be an array");
        }

        return array_filter($items, function($item) use ($condition, $data) {
            $itemData = ['item' => $item] + $data;
            return $this->evaluateCondition($condition, $itemData);
        });
    }

    private function evaluateCondition(string $condition, array $data)
    {
        $condition = $this->replaceVariables($condition, $data);
        $allowedConditions = ['==', '!=', '>', '<', '>=', '<='];
        foreach ($allowedConditions as $allowedCondition) {
            if (strpos($condition, $allowedCondition) !== false) {
                list($left, $right) = explode($allowedCondition, $condition);
                $left = $this->evaluateExpression(trim($left), $data);
                $right = $this->evaluateExpression(trim($right), $data);
                switch ($allowedCondition) {
                    case '==': return $left == $right;
                    case '!=': return $left != $right;
                    case '>': return $left > $right;
                    case '<': return $left < $right;
                    case '>=': return $left >= $right;
                    case '<=': return $left <= $right;
                }
            }
        }
        throw new \RuntimeException("Unsupported condition: $condition");
    }

    private function evaluateExpression($expression, array $data)
    {
        if (is_numeric($expression)) {
            return $expression + 0; // Convert to number
        }
        if ($expression === 'true') {
            return true;
        }
        if ($expression === 'false') {
            return false;
        }
        if (isset($data[$expression])) {
            return $data[$expression];
        }
        return $expression; // Treat as string
    }

    private function replaceVariables(string $string, array $data)
    {
        return preg_replace_callback('/\$(\w+)/', function($matches) use ($data) {
            $variableName = $matches[1];
            return $data[$variableName] ?? '';
        }, $string);
    }
}
