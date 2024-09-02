<?php

namespace phpStack\TemplateSystem\Core\Template;

use phpStack\TemplateSystem\Core\Template\Plugins\ComponentPlugin;
use Psr\Cache\CacheItemPoolInterface;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginManager;

class TemplateEngine
{
    private string $templateDir;
    private PerformanceProfiler $profiler;
    private CacheItemPoolInterface $cache;
    private ComponentPlugin $componentPlugin;
    private string $globalCss = '';
    private string $globalJs = '';
    /** @var array<string, callable> */
    private array $extensions = [];
    /** @var array<string, callable> */
    private array $requestHandlers = [];
    private HtmxPluginManager $htmxPluginManager;
    private TemplateParser $parser;
    private TemplateRenderer $renderer;
    private BuildSystem $buildSystem;
    private string $outputDir;
    private CacheManager $cacheManager;

    public function __construct(
        string $templateDir,
        PerformanceProfiler $profiler,
        CacheManager $cacheManager,
        ComponentPlugin $componentPlugin,
        HtmxPluginManager $htmxPluginManager,
        TemplateParser $parser,
        TemplateRenderer $renderer,
        BuildSystem $buildSystem,
        string $outputDir
    ) {
        $this->templateDir = $templateDir;
        $this->profiler = $profiler;
        $this->cacheManager = $cacheManager;
        $this->componentPlugin = $componentPlugin;
        $this->htmxPluginManager = $htmxPluginManager;
        $this->parser = $parser;
        $this->renderer = $renderer;
        $this->buildSystem = $buildSystem;
        $this->outputDir = $outputDir;
    }

    public function render(string $template, array $data = []): string
    {
        $cacheKey = $this->cacheManager->generateCacheKey($template, $data);
        if ($this->cacheManager->has($cacheKey)) {
            return $this->cacheManager->get($cacheKey);
        }

        $this->profiler->startProfile('render');
        $parsedTemplate = $this->parser->parse($template);
        $renderedContent = $this->renderer->render($parsedTemplate, $data);
        $processedContent = $this->applyHtmxPlugins($renderedContent);
        $this->profiler->endProfile('render');

        $this->cacheManager->set($cacheKey, $processedContent);
        return $processedContent;
    }

    public function registerComponent(string $name, callable $component, ?string $style = null, ?string $script = null, array $events = [], array $dependencies = []): void
    {
        $this->componentPlugin->register($name, $component, $style, $script, $events, $dependencies);
    }

    public function registerGlobalAssets(string $css, string $js): void
    {
        $this->globalCss = $css;
        $this->globalJs = $js;
    }

    public function registerExtension(string $name, callable $extension): void
    {
        $this->extensions[$name] = $extension;
    }

    public function registerRequestHandler(string $name, callable $handler): void
    {
        $this->requestHandlers[$name] = $handler;
    }

    /**
     * @param array<string, mixed> $args
     */
    public function executeExtension(string $name, array $args = []): mixed
    {
        if (!isset($this->extensions[$name])) {
            throw new \RuntimeException("Extension '{$name}' is not registered.");
        }
        return $this->extensions[$name](...$args);
    }

    /**
     * @param array<string, mixed> $args
     */
    public function executeRequestHandler(string $name, array $args = []): mixed
    {
        if (!isset($this->requestHandlers[$name])) {
            throw new \RuntimeException("Request handler '{$name}' is not registered.");
        }
        return $this->requestHandlers[$name](...$args);
    }

    private function generateCacheKey(string $template, array $data): string
    {
        return md5($template . serialize($data));
    }

    private function injectGlobalAssets(string $rendered): string
    {
        $styleTag = $this->globalCss ? "<style>{$this->globalCss}</style>" : '';
        $scriptTag = $this->globalJs ? "<script>{$this->globalJs}</script>" : '';

        return str_replace(
            '</head>',
            $styleTag . $scriptTag . '</head>',
            $rendered
        );
    }

    public function getComponentPlugin(): ComponentPlugin
    {
        return $this->componentPlugin;
    }

    public function renderComponent(string $name, array $args = [], array $data = []): string
    {
        return $this->componentPlugin->execute(['name' => $name] + $args, $data);
    }

    public function build(): void
    {
        $this->buildSystem->build();
    }

    public function watch(): void
    {
        $this->buildSystem->watch();
    }

    public function useOptimizedComponents(): void
    {
        $this->componentPlugin->useOptimizedComponents($this->outputDir);
    }

    public function executePlugin(string $name, array $args, array $data)
    {
        $plugin = $this->htmxPluginManager->getPlugin($name);
        if ($plugin instanceof PluginInterface) {
            return $plugin->execute($args, $data);
        }
        throw new \RuntimeException("Plugin '$name' not found or is not an instance of PluginInterface");
    }
}