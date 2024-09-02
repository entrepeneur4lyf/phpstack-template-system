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

        $items = $this->getItemsArray($input, $data);

        if (!is_array($items) && !($items instanceof \Traversable)) {
            throw new \RuntimeException("Filter plugin input must be an array or Traversable");
        }

        return array_filter($items, function($item) use ($condition, $data) {
            $itemData = ['item' => $item] + $data;
            return $this->evaluateCondition($condition, $itemData);
        });
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

    private function evaluateCondition($condition, array $data)
    {
        if (is_callable($condition)) {
            return $condition($data);
        }

        if (is_string($condition)) {
            $condition = $this->replaceVariables($condition, $data);
            return $this->safeEval($condition);
        }

        return (bool) $condition;
    }

    private function replaceVariables(string $string, array $data)
    {
        return preg_replace_callback('/\$(\w+)/', function($matches) use ($data) {
            $variableName = $matches[1];
            return isset($data[$variableName]) ? var_export($data[$variableName], true) : 'null';
        }, $string);
    }

    private function safeEval(string $code)
    {
        $safeCode = strtr($code, [
            'echo' => '',
            'print' => '',
            'eval' => '',
            'exec' => '',
            'system' => '',
            'shell_exec' => '',
            'passthru' => '',
            'popen' => '',
            'proc_open' => '',
            'pcntl_exec' => '',
        ]);

        $result = null;
        $error = null;

        set_error_handler(function($severity, $message, $file, $line) use (&$error) {
            $error = $message;
        });

        try {
            $result = eval("return $safeCode;");
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        restore_error_handler();

        if ($error !== null) {
            throw new \RuntimeException("Error evaluating condition: $error");
        }

        return $result;
    }
}
