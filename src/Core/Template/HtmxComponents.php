<?php

namespace phpStack\TemplateSystem\Core\Template;

use phpStack\TemplateSystem\Core\Plugins\PluginManager;

/**
 * Class HtmxComponents
 *
 * Manages a collection of HTMX components.
 */
class HtmxComponents
{
    private HtmxConfig $config;
    /** @var array<callable> */
    /** @var array<callable> */
    private array $beforeRequestHooks = [];
    /** @var array<callable> */
    private array $beforeRenderHooks = [];
    private PluginManager $pluginManager;
    private ComponentDesigner $componentDesigner;

    public function __construct(
        TemplateEngine $engine,
        HtmxConfig $config,
        PluginManager $pluginManager,
        ComponentDesigner $componentDesigner
    ) {
        $this->config = $config;
        $this->pluginManager = $pluginManager;
        $this->componentDesigner = $componentDesigner;
        $this->registerAll($engine);
    }

    public function registerAll(TemplateEngine $engine): void
    {
        $this->registerComponents($engine);
        $this->registerExtensions($engine);
        $this->registerRequestHandlers($engine);
        $this->registerHooks($engine);
        $this->registerWebComponentSupport($engine);
        $this->initializePlugins($engine);
        $this->registerResponseHandlers($engine);
        $this->registerEventHandlers($engine);
        $this->registerJavaScriptAPI($engine);
    }

    public function registerPlugin(string $name, PluginInterface|callable $plugin, string $version): void
    {
        $this->pluginManager->registerPlugin($name, $plugin, $version);
    }

    private function initializePlugins(TemplateEngine $engine): void
    {
        foreach ($this->pluginManager->getAll() as $name => $plugin) {
            try {
                if (is_callable($plugin)) {
                    $plugin($engine, $this->config);
                } elseif ($plugin instanceof PluginInterface && method_exists($plugin, 'initialize')) {
                    $plugin->initialize($engine, $this->config);
                }
            } catch (\Throwable $e) {
                $engine->getErrorHandler()->handleError("Error initializing plugin '$name': " . $e->getMessage(), 0, $e);
            }
        }
    }

    public function getPlugin(string $name): ?PluginInterface
    {
        return $this->pluginManager->getPlugin($name);
    }

    public function hasPlugin(string $name): bool
    {
        return $this->pluginManager->hasPlugin($name);
    }

    public function updatePlugin(string $name, PluginInterface|callable $newPlugin, string $version): void
    {
        if (method_exists($this->pluginManager, 'updatePlugin')) {
            $this->pluginManager->updatePlugin($name, $newPlugin, $version);
        } else {
            throw new \RuntimeException("Method 'updatePlugin' not found in PluginManager");
        }
    }

    public function resolveConflicts(array $conflictingPlugins): void
    {
        $this->pluginManager->resolveConflicts($conflictingPlugins);
    }

    public function getComponentDesigner(): ComponentDesigner
    {
        return $this->componentDesigner;
    }

    private function registerWebComponentSupport(TemplateEngine $engine): void
    {
        $engine->registerExtension('htmx-process-shadow-dom', function (string $shadowRoot) use ($engine): string {
            try {
                return "htmx.process(document.querySelector('{$shadowRoot}').shadowRoot);";
            } catch (\Throwable $e) {
                $engine->getErrorHandler()->handleError("Error processing shadow DOM: " . $e->getMessage(), 0, $e);
                return '';
            }
        });
    }

    public function addBeforeRequestHook(callable $hook): void
    {
        $this->beforeRequestHooks[] = $hook;
    }

    public function addBeforeRenderHook(callable $hook): void
    {
        $this->beforeRenderHooks[] = $hook;
    }

    private function registerComponents(TemplateEngine $engine): void
    {
        $components = [
            'htmx-element' => ElementComponent::class,
            'htmx-button' => ButtonComponent::class,
            'htmx-form' => FormComponent::class,
            'htmx-select' => SelectComponent::class,
            'htmx-input' => InputComponent::class,
            'htmx-div' => DivComponent::class,
            'htmx-a' => AnchorComponent::class,
            'htmx-inline-validation' => InlineValidationComponent::class,
            'htmx-infinite-scroll' => InfiniteScrollComponent::class,
            'htmx-modal' => ModalComponent::class,
            'htmx-event-listener' => EventListenerComponent::class,
            'htmx-logger' => LoggerComponent::class,
            'htmx-boost' => BoostComponent::class,
            'htmx-pagination' => PaginationComponent::class,
        ];

        foreach ($components as $name => $class) {
            $engine->registerComponent($name, [$class, 'render']);
        }
    }

    private function registerExtensions(TemplateEngine $engine): void
    {
        $extensions = [
            'htmx-json-enc' => fn($value) => htmlspecialchars(json_encode($value) ?: '', ENT_QUOTES, 'UTF-8'),
            'htmx-csrf-token' => fn() => $this->generateCsrfToken(),
            'htmx-url-encode' => fn(string $value) => urlencode($value),
            'htmx-event-handler' => fn(string $event, string $handler) => "document.body.addEventListener('htmx:$event', function(evt) { $handler(evt); });",
            'htmx-plugin' => fn(string $pluginName) => "<script>htmx.defineExtension('$pluginName', {});</script>",
            'htmx-boost' => fn(bool $enabled = true) => $enabled ? 'hx-boost="true"' : '',
        ];

        foreach ($extensions as $name => $callback) {
            $engine->registerExtension($name, $callback);
        }
    }

    private function registerRequestHandlers(TemplateEngine $engine): void
    {
        $engine->registerRequestHandler('htmx-request', [HtmxRequestHandler::class, 'handle']);
    }

    private function registerHooks(TemplateEngine $engine): void
    {
        $engine->registerExtension('htmx-before-request', function (callable $callback): void {
            $this->addBeforeRequestHook($callback);
        });

        $engine->registerExtension('htmx-before-render', function (callable $callback): void {
            $this->addBeforeRenderHook($callback);
        });
    }

    private function registerResponseHandlers(TemplateEngine $engine): void
    {
        if (method_exists($engine, 'registerResponseHandler')) {
            $engine->registerResponseHandler('htmx-response', [HtmxResponseHandler::class, 'addHeaders']);
        } else {
            throw new \RuntimeException("Method 'registerResponseHandler' not found in TemplateEngine");
        }
    }

    private function registerEventHandlers(TemplateEngine $engine): void
    {
        $engine->registerExtension('htmx-event-script', function(...$args) {
            if (class_exists(HtmxEventHandler::class) && method_exists(HtmxEventHandler::class, 'getEventScript')) {
                return HtmxEventHandler::getEventScript(...$args);
            }
            throw new \RuntimeException("HtmxEventHandler class or getEventScript method not found");
        });
    }

    private function registerJavaScriptAPI(TemplateEngine $engine): void
    {
        $engine->registerExtension('htmx-api-script', function() {
            $config = json_encode($this->config->toArray());
            return "<script src='/js/htmx-api.js'></script>
                    <script>htmx.config = $config;</script>";
        });
    }

    public function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $token;
        }
        
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
