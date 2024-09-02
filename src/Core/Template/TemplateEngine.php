<?php

namespace phpStack\TemplateSystem\Core\Template;

use phpStack\TemplateSystem\Core\Template\Plugins\ComponentPlugin;
use Psr\Cache\CacheItemPoolInterface;
use phpStack\TemplateSystem\Core\Plugins\HtmxPluginManager;

/**
 * Class TemplateEngine
 *
 * The main engine for rendering templates.
 */
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

    /**
     * TemplateEngine constructor.
     *
     * @param string $templateDir The directory containing templates.
     * @param PerformanceProfiler $profiler The profiler for performance measurement.
     * @param CacheManager $cacheManager The cache manager for caching templates.
     * @param ComponentPlugin $componentPlugin The component plugin for managing components.
     * @param HtmxPluginManager $htmxPluginManager The HTMX plugin manager.
     * @param TemplateParser $parser The parser for parsing templates.
     * @param TemplateRenderer $renderer The renderer for rendering templates.
     * @param BuildSystem $buildSystem The build system for building templates.
     * @param string $outputDir The directory for output files.
     */
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

    /**
     * Renders a template with the given data.
     *
     * @param string $template The template to render.
     * @param array<string, mixed> $data The data to use in the template.
     * @return string The rendered template content.
     */
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

    /**
     * Registers a component with the template engine.
     *
     * @param string $name The name of the component.
     * @param callable $component The component callable.
     * @param string|null $style Optional CSS style for the component.
     * @param string|null $script Optional JavaScript for the component.
     * @param array<string> $events Optional events associated with the component.
     * @param array<string> $dependencies Optional dependencies for the component.
     */
    public function registerComponent(string $name, callable $component, ?string $style = null, ?string $script = null, array $events = [], array $dependencies = []): void
    {
        $this->componentPlugin->register($name, $component, $style, $script, $events, $dependencies);
    }

    /**
     * Registers global CSS and JavaScript assets.
     *
     * @param string $css The global CSS content.
     * @param string $js The global JavaScript content.
     */
    public function registerGlobalAssets(string $css, string $js): void
    {
        $this->globalCss = $css;
        $this->globalJs = $js;
    }

    /**
     * Registers an extension with the template engine.
     *
     * @param string $name The name of the extension.
     * @param callable $extension The extension callable.
     */
    public function registerExtension(string $name, callable $extension): void
    {
        $this->extensions[$name] = $extension;
    }

    /**
     * Registers a request handler with the template engine.
     *
     * @param string $name The name of the request handler.
     * @param callable $handler The request handler callable.
     */
    public function registerRequestHandler(string $name, callable $handler): void
    {
        $this->requestHandlers[$name] = $handler;
    }

    /**
     * Executes a registered extension with the given arguments.
     *
     * @param string $name The name of the extension.
     * @param array<string, mixed> $args The arguments for the extension.
     * @return mixed The result of the extension execution.
     * @throws \RuntimeException If the extension is not registered.
     */
    public function executeExtension(string $name, array $args = []): mixed
    {
        if (!isset($this->extensions[$name])) {
            throw new \RuntimeException("Extension '{$name}' is not registered.");
        }
        return $this->extensions[$name](...$args);
    }

    /**
     * Executes a registered request handler with the given arguments.
     *
     * @param string $name The name of the request handler.
     * @param array<string, mixed> $args The arguments for the request handler.
     * @return mixed The result of the request handler execution.
     * @throws \RuntimeException If the request handler is not registered.
     */
    public function executeRequestHandler(string $name, array $args = []): mixed
    {
        if (!isset($this->requestHandlers[$name])) {
            throw new \RuntimeException("Request handler '{$name}' is not registered.");
        }
        return $this->requestHandlers[$name](...$args);
    }

    /**
     * Generates a cache key for a template and data.
     *
     * @param string $template The template name.
     * @param array<string, mixed> $data The data for the template.
     * @return string The generated cache key.
     */
    private function generateCacheKey(string $template, array $data): string
    {
        return md5($template . serialize($data));
    }

    /**
     * Injects global CSS and JavaScript assets into the rendered content.
     *
     * @param string $rendered The rendered content.
     * @return string The content with injected global assets.
     */
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

    /**
     * Returns the component plugin instance.
     *
     * @return ComponentPlugin The component plugin.
     */
    public function getComponentPlugin(): ComponentPlugin
    {
        return $this->componentPlugin;
    }

    /**
     * Renders a component with the given name, arguments, and data.
     *
     * @param string $name The name of the component.
     * @param array<string, mixed> $args The arguments for the component.
     * @param array<string, mixed> $data The data for the component.
     * @return string The rendered component content.
     */
    public function renderComponent(string $name, array $args = [], array $data = []): string
    {
        return $this->componentPlugin->execute(['name' => $name] + $args, $data);
    }

    /**
     * Builds the templates using the build system.
     */
    public function build(): void
    {
        $this->buildSystem->build();
    }

    /**
     * Watches for changes and rebuilds templates as needed.
     */
    public function watch(): void
    {
        $this->buildSystem->watch();
    }

    /**
     * Uses optimized components for rendering.
     */
    public function useOptimizedComponents(): void
    {
        $this->componentPlugin->useOptimizedComponents($this->outputDir);
    }

    /**
     * Executes a plugin with the given name, arguments, and data.
     *
     * @param string $name The name of the plugin.
     * @param array<string, mixed> $args The arguments for the plugin.
     * @param array<string, mixed> $data The data for the plugin.
     * @return mixed The result of the plugin execution.
     * @throws \RuntimeException If the plugin is not found or not an instance of PluginInterface.
     */
    public function executePlugin(string $name, array $args, array $data)
    {
        $plugin = $this->htmxPluginManager->getPlugin($name);
        if ($plugin instanceof PluginInterface) {
            return $plugin->execute($args, $data);
        }
        throw new \RuntimeException("Plugin '$name' not found or is not an instance of PluginInterface");
    }
}
