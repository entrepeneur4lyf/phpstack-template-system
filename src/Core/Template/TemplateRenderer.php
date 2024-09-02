<?php

namespace phpStack\TemplateSystem\Core\Template;

use Fiber;

class TemplateRenderer
{
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function render(array $parsedTemplate, array $data): string
    {
        $output = '';
        $fibers = [];

        foreach ($parsedTemplate as $part) {
            if ($part['type'] === 'text') {
                $output .= $part['content'];
            } elseif ($part['type'] === 'plugin') {
                $result = $this->executePluginChain($part, $data);
                if ($result instanceof Fiber) {
                    $fibers[] = $result;
                    $output .= "<!-- async_component_placeholder_" . (count($fibers) - 1) . " -->";
                } else {
                    $output .= $result;
                }
            }
        }

        // Start all fibers
        foreach ($fibers as $fiber) {
            $fiber->start();
        }

        // Replace placeholders with actual content
        foreach ($fibers as $index => $fiber) {
            $asyncContent = $fiber->resume();
            $output = str_replace(
                "<!-- async_component_placeholder_$index -->",
                $asyncContent,
                $output
            );
        }

        return $output;
    }

    private function executePluginChain(array $pluginData, array $data)
    {
        try {
            $result = $this->executePlugin($pluginData['name'], $pluginData['args'], $data);

            foreach ($pluginData['chain'] as $chainedPlugin) {
                if ($result instanceof Fiber) {
                    $result = new Fiber(function() use ($result, $chainedPlugin, $data) {
                        try {
                            $prevResult = $result->resume();
                            return $this->executePlugin($chainedPlugin['name'], $chainedPlugin['args'], ['input' => $prevResult] + $data);
                        } catch (\Throwable $e) {
                            $this->errorHandler->handleError("Error in chained plugin execution: " . $e->getMessage(), 0, $e);
                            return null;
                        }
                    });
                } else {
                    $result = $this->executePlugin($chainedPlugin['name'], $chainedPlugin['args'], ['input' => $result] + $data);
                }
            }

            return $result;
        } catch (\Throwable $e) {
            $this->errorHandler->handleError("Error in plugin chain execution: " . $e->getMessage(), 0, $e);
            return null;
        }
    }

    private function executePlugin(string $name, array $args, array $data)
    {
        return $this->pluginManager->execute($name, $args, $data);
    }
}