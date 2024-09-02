<?php

namespace phpStack\TemplateSystem\Core\Template;

use phpStack\TemplateSystem\Core\Plugins\PluginManager;

/**
 * Class ComponentDesigner
 *
 * Provides tools for designing and managing components.
 */
class ComponentDesigner
{
    private TemplateEngine $engine;
    private PluginManager $pluginManager;
    /** @var array<string, string> */
    private array $componentCache = [];

    public function __construct(TemplateEngine $engine, PluginManager $pluginManager)
    {
        $this->engine = $engine;
        $this->pluginManager = $pluginManager;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function createComponent(string $name, array $options = []): string
    {
        if (isset($this->componentCache[$name])) {
            return $this->componentCache[$name];
        }

        $componentTemplate = $this->generateComponentTemplate($name, $options);
        $this->engine->registerComponent($name, function(array $args, $data) use ($componentTemplate) {
            return $this->engine->render($componentTemplate, array_merge($args, $data));
        });

        $this->componentCache[$name] = $componentTemplate;
        return $componentTemplate;
    }

    /**
     * @param array<string, mixed> $options
     */
    private function generateComponentTemplate(string $name, array $options): string
    {
        $template = "<div class=\"component {$name}\" data-component=\"{$name}\">\n";
        
        foreach ($options as $optionName => $optionValue) {
            if (is_array($optionValue)) {
                $template .= $this->generateNestedComponent($optionName, $optionValue);
            } elseif ($optionName === 'attributes' && is_array($optionValue)) {
                $template .= $this->generateAttributes($optionValue);
            } elseif (is_scalar($optionValue) || is_null($optionValue)) {
                $template .= "    <{$optionName}>{{\${$optionName}}}</{$optionName}>\n";
            }
        }

        $template .= $this->applyPlugins($name, $options);
        $template .= $this->generateLifecycleHooks($name);

        $template .= "</div>";

        return $template;
    }

    /**
     * @param array<string, mixed> $options
     */
    private function generateNestedComponent(string $name, array $options): string
    {
        $nestedTemplate = "    <div class=\"nested-component {$name}\" data-nested-component=\"{$name}\">\n";
        foreach ($options as $optionName => $optionValue) {
            if ($optionName === 'attributes' && is_array($optionValue)) {
                $nestedTemplate .= $this->generateAttributes($optionValue, 8);
            } elseif (is_scalar($optionValue) || is_null($optionValue)) {
                $nestedTemplate .= "        <{$optionName}>{{\${$optionName}}}</{$optionName}>\n";
            }
        }
        $nestedTemplate .= "    </div>\n";
        return $nestedTemplate;
    }

    /**
     * @param array<string, string> $attributes
     */
    private function generateAttributes(array $attributes, int $indentation = 4): string
    {
        $attributeString = '';
        $indent = str_repeat(' ', $indentation);
        foreach ($attributes as $key => $value) {
            $attributeString .= "{$indent}{$key}=\"{{\${$value}}}\"\n";
        }
        return $attributeString;
    }

    /**
     * @param array<string, mixed> $options
     */
    /**
     * Applies plugins to a component.
     *
     * @param string $name The name of the component.
     * @param array<string, mixed> $options The options for the component.
     * @return string The output after applying plugins.
     */
    private function applyPlugins(string $name, array $options): string
    {
        $pluginOutput = "";
        foreach ($this->pluginManager->getAll() as $pluginName => $plugin) {
            if ($plugin instanceof PluginInterface && method_exists($plugin, 'applyToComponent')) {
                $pluginOutput .= $plugin->applyToComponent($name, $options);
            }
        }
        return $pluginOutput;
    }

    /**
     * Generates lifecycle hooks for a component.
     *
     * @param string $name The name of the component.
     * @return string The JavaScript code for lifecycle hooks.
     */
    private function generateLifecycleHooks(string $name): string
    {
        return "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var component = document.querySelector('[data-component=\"{$name}\"]');
                    if (component && typeof htmx !== 'undefined' && htmx.onLoad) {
                        htmx.onLoad(component);
                    }
                });
            </script>
        ";
    }

    public function getComponentTemplate(string $name): ?string
    {
        return $this->componentCache[$name] ?? null;
    }

    /**
     * @return array<string>
     */
    public function listComponents(): array
    {
        return array_keys($this->componentCache);
    }
}
