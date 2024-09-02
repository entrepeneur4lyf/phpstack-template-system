<?php

namespace phpStack\TemplateSystem\Core\Template\Plugins;

use phpStack\TemplateSystem\Core\Template\PluginInterface;
use phpStack\TemplateSystem\Core\Template\TemplateEngine;

class IfPlugin implements PluginInterface
{
    private $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function execute(array $args, array $data)
    {
        $condition = $args['condition'] ?? null;
        if ($condition === null) {
            throw new \RuntimeException("If plugin requires a 'condition' argument");
        }

        $thenTemplate = $args['then'] ?? null;
        $elseTemplate = $args['else'] ?? null;

        if ($thenTemplate === null) {
            throw new \RuntimeException("If plugin requires a 'then' argument");
        }

        $result = $this->evaluateCondition($condition, $data);

        if ($result) {
            return $this->templateEngine->render($thenTemplate, $data);
        } elseif ($elseTemplate !== null) {
            return $this->templateEngine->render($elseTemplate, $data);
        }

        return '';
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
