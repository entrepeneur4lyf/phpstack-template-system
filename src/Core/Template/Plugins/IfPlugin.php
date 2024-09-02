<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;

class IfPlugin implements PluginInterface
{
    public function execute(array $args, array $data)
    {
        $condition = $args['condition'] ?? null;
        if ($condition === null) {
            throw new \RuntimeException("If plugin requires a 'condition' argument");
        }

        $result = $this->evaluateCondition($condition, $data);
        return $result ? ($args['then'] ?? '') : ($args['else'] ?? '');
    }

    private function evaluateCondition(string $condition, array $data)
    {
        $condition = $this->replaceVariables($condition, $data);
        return eval("return $condition;");
    }

    private function replaceVariables(string $string, array $data)
    {
        return preg_replace_callback('/\$(\w+)/', function($matches) use ($data) {
            $variableName = $matches[1];
            return $data[$variableName] ?? '';
        }, $string);
    }
}