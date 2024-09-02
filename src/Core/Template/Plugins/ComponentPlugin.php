<?php

namespace phpStack\TemplateSystem\Core\Template\Plugins;

use phpStack\TemplateSystem\Core\Plugins\PluginInterface;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use phpStack\TemplateSystem\Core\Template\LazyLoadedComponent;
use phpStack\TemplateSystem\Core\Template\PluginSandbox;
use Psr\Cache\CacheItemPoolInterface;
use Fiber;
use phpStack\TemplateSystem\Core\Exceptions\ErrorHandler;

class ComponentPlugin implements PluginInterface
{
    /** @var array<string, array{component: callable|LazyLoadedComponent, style: ?string, script: ?string, events: array, dependencies: array}> */
    private array $components = [];
    /** @var array<string, string> */
    private array $styles = [];
    /** @var array<string, string> */
    private array $scripts = [];
    /** @var array<string, array> */
    private array $events = [];
    /** @var array<string, array> */
    private array $dependencies = [];
    private PerformanceProfiler $profiler;
    private CacheManager $cacheManager;
    private PluginSandbox $sandbox;
    private string $optimizedComponentsDir = '';
    private bool $useOptimizedComponents = false;
    private ErrorHandler $errorHandler;
    private DebugManager $debugManager;

    public function __construct(
        PerformanceProfiler $profiler,
        CacheManager $cacheManager,
        PluginSandbox $sandbox,
        DebugManager $debugManager,
        ErrorHandler $errorHandler
    ) {
        $this->profiler = $profiler;
        $this->cacheManager = $cacheManager;
        $this->sandbox = $sandbox;
        $this->debugManager = $debugManager;
        $this->errorHandler = $errorHandler;
    }

    public function execute(array $args, array $data)
    {
        $name = $args['name'] ?? null;
        if ($name === null) {
            throw new \RuntimeException("Component plugin requires a 'name' argument");
        }

        if ($this->useOptimizedComponents) {
            return $this->executeOptimizedComponent($name, $args, $data);
        }

        if (!isset($this->components[$name])) {
            throw new \RuntimeException("Component '{$name}' is not registered");
        }

        $cacheKey = $this->cacheManager->generateCacheKey($name, $args);
        if ($this->cacheManager->has($cacheKey)) {
            return $this->cacheManager->get($cacheKey);
        }

        $component = $this->components[$name]['component'];
        if ($component instanceof LazyLoadedComponent) {
            $component = $component->load();
        }

        $useShadowDom = $args['shadowDom'] ?? false;
        $serverSideRender = $args['ssr'] ?? true;
        $isAsync = $args['async'] ?? false;

        // Handle dependencies
        $dependencyResults = $this->resolveDependencies($name);

        $this->profiler->startProfile($name);

        try {
            if ($isAsync) {
                if (!class_exists('Fiber')) {
                    throw new \RuntimeException("Fiber is not supported in this environment.");
                }
                return new Fiber(function() use ($component, $args, $data, $name, $useShadowDom, $serverSideRender, $dependencyResults, $cacheKey) {
                    $content = $this->sandbox->execute($component, $args, array_merge($data, $dependencyResults));
                    $this->profiler->endProfile($name);
                    $result = $serverSideRender ? $this->serverSideRender($name, $content, $useShadowDom) : $this->clientSideRender($name, $content, $useShadowDom);
                    $this->cacheManager->set($cacheKey, $result);
                    return $result;
                });
            } else {
                $content = $this->sandbox->execute($component, $args, array_merge($data, $dependencyResults));
                $this->profiler->endProfile($name);
                $result = $serverSideRender ? $this->serverSideRender($name, $content, $useShadowDom) : $this->clientSideRender($name, $content, $useShadowDom);
                $this->cacheManager->set($cacheKey, $result);
                return $result;
            }
        } catch (\Throwable $e) {
            $this->profiler->endProfile($name);
            $this->errorHandler->handleError("Component execution failed: " . $e->getMessage(), 0, $e);
            $this->debugManager->logError($name, $e);
            return null;
        }
    }

    private function executeOptimizedComponent(string $name, array $args, array $data): ?string
    {
        $optimizedComponentPath = $this->optimizedComponentsDir . '/' . $name . '.php';
        if (!file_exists($optimizedComponentPath)) {
            $this->errorHandler->handleError("Optimized component '{$name}' not found");
            return null;
        }

        try {
            $optimizedComponent = require $optimizedComponentPath;
            $render = $optimizedComponent['render'];
            return $render($args, $data);
        } catch (\Throwable $e) {
            $this->errorHandler->handleError("Optimized component execution failed: " . $e->getMessage(), 0, $e);
            $this->debugManager->logError($name, $e);
            return null;
        }
    }

    public function register(string $name, callable $component, ?string $style = null, ?string $script = null, array $events = [], array $dependencies = []): void
    {
        $this->components[$name] = [
            'component' => $component,
            'style' => $style,
            'script' => $script,
            'events' => $events,
            'dependencies' => $dependencies
        ];
        if ($style) {
            $this->styles[$name] = $style;
        }
        if ($script) {
            $this->scripts[$name] = $script;
        }
        if (!empty($events)) {
            $this->events[$name] = $events;
        }
        if (!empty($dependencies)) {
            $this->dependencies[$name] = $dependencies;
        }
    }

    public function registerLazy(string $name, callable $loader): void
    {
        $this->components[$name]['component'] = new LazyLoadedComponent($loader);
    }

    private function resolveDependencies(string $name): array
    {
        $dependencyResults = [];
        if (isset($this->dependencies[$name])) {
            foreach ($this->dependencies[$name] as $dependencyName) {
                if (isset($this->components[$dependencyName])) {
                    $dependencyResults[$dependencyName] = $this->execute(['name' => $dependencyName], []);
                }
            }
        }
        return $dependencyResults;
    }

    private function serverSideRender(string $name, string $content, bool $useShadowDom): string
    {
        $style = $this->styles[$name] ?? '';
        $script = $this->scripts[$name] ?? '';
        $events = $this->events[$name] ?? [];

        $renderedContent = $content;
        if ($useShadowDom) {
            $renderedContent = "<div id=\"component-{$name}\">{$content}</div>";
            $script .= "
                <script>
                    (function() {
                        const root = document.getElementById('component-{$name}');
                        const shadowRoot = root.attachShadow({mode: 'open'});
                        shadowRoot.innerHTML = `{$content}`;
                    })();
                </script>
            ";
        }

        $styleTag = $style ? "<style>{$style}</style>" : '';
        $scriptTag = $script ? "<script>{$script}</script>" : '';
        $eventHandlers = '';
        foreach ($events as $event => $handler) {
            $eventHandlers .= "document.getElementById('component-{$name}').addEventListener('{$event}', {$handler});";
        }
        $eventScript = $eventHandlers ? "<script>{$eventHandlers}</script>" : '';

        return "{$styleTag}{$renderedContent}{$scriptTag}{$eventScript}";
    }

    private function clientSideRender(string $name, string $content, bool $useShadowDom): string
    {
        $placeholder = "<div id=\"component-{$name}-placeholder\"></div>";
        $script = $this->scripts[$name] ?? '';
        $events = $this->events[$name] ?? [];

        $renderScript = "
            <script>
                (function() {
                    const placeholder = document.getElementById('component-{$name}-placeholder');
                    const content = `{$content}`;
                    " . ($useShadowDom ? "
                    const shadowRoot = placeholder.attachShadow({mode: 'open'});
                    shadowRoot.innerHTML = content;
                    " : "
                    placeholder.innerHTML = content;
                    ") . "
                })();
            </script>
        ";

        $eventHandlers = '';
        foreach ($events as $event => $handler) {
            $eventHandlers .= "document.getElementById('component-{$name}-placeholder').addEventListener('{$event}', {$handler});";
        }
        $eventScript = $eventHandlers ? "<script>{$eventHandlers}</script>" : '';

        return "{$placeholder}{$renderScript}{$script}{$eventScript}";
    }

    private function generateCacheKey(string $name, array $args): string
    {
        return md5($name . serialize($args));
    }

    public function getDependencies(): array
    {
        return [];
    }

    public function applyToComponent(string $name, array $options): string
    {
        if (!isset($this->components[$name])) {
            return '';
        }

        $component = $this->components[$name];
        $output = '';

        // Apply styles
        if (isset($component['style'])) {
            $output .= "<style>{$component['style']}</style>";
        }

        // Apply scripts
        if (isset($component['script'])) {
            $output .= "<script>{$component['script']}</script>";
        }

        // Apply event handlers
        if (isset($component['events'])) {
            $eventHandlers = '';
            foreach ($component['events'] as $event => $handler) {
                $eventHandlers .= "document.querySelector('[data-component=\"{$name}\"]').addEventListener('{$event}', {$handler});";
            }
            $output .= "<script>{$eventHandlers}</script>";
        }

        return $output;
    }

    public function processHtmxContent(string $content): string
    {
        // Process HTMX-specific attributes
        $content = preg_replace_callback(
            '/<([^>]+)\s+hx-([^=]+)="([^"]+)"/',
            function ($matches) {
                $tag = $matches[1];
                $attribute = $matches[2];
                $value = $matches[3];
                return "<{$tag} data-hx-{$attribute}=\"{$value}\"";
            },
            $content
        );

        // Process HTMX-specific elements
        $content = preg_replace_callback(
            '/<hx-([^>\s]+)([^>]*)>/',
            function ($matches) {
                $element = $matches[1];
                $attributes = $matches[2];
                return "<div data-hx-{$element}{$attributes}>";
            },
            $content
        );

        $content = str_replace('</hx-', '</div>', $content);

        return $content;
    }

    public function useOptimizedComponents(string $outputDir): void
    {
        $this->optimizedComponentsDir = $outputDir;
        $this->useOptimizedComponents = true;
    }
}