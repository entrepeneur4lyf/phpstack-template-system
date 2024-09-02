<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class HtmxConfig
 *
 * Configuration settings for HTMX integration.
 */
class HtmxConfig
{
    private $config = [
        'historyEnabled' => true,
        'historyCacheSize' => 10,
        'refreshOnHistoryMiss' => false,
        'defaultSwapStyle' => 'innerHTML',
        'defaultSwapDelay' => 0,
        'defaultSettleDelay' => 20,
        'includeIndicatorStyles' => true,
        'indicatorClass' => 'htmx-indicator',
        'requestClass' => 'htmx-request',
        'addedClass' => 'htmx-added',
        'settlingClass' => 'htmx-settling',
        'swappingClass' => 'htmx-swapping',
        'allowEval' => true,
        'allowScriptTags' => true,
        'inlineScriptNonce' => '',
        'attributesToSettle' => ['class', 'style', 'width', 'height'],
        'withCredentials' => false,
        'timeout' => 0,
        'wsReconnectDelay' => 'full-jitter',
        'wsBinaryType' => 'blob',
        'disableSelector' => '[hx-disable], [data-hx-disable]',
        'useTemplateFragments' => false,
        'scrollBehavior' => 'smooth',
        'defaultFocusScroll' => false,
        'getCacheBusterParam' => true,
        'globalViewTransitions' => false,
        'methodsThatUseUrlParams' => ['get'],
        'selfRequestsOnly' => false,
        'ignoreTitle' => false,
        'scrollIntoViewOnBoost' => true,
        'triggerSpecsCache' => null,
    ];

    public function set(string $key, $value): void
    {
        if (array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
    }

    public function get(string $key)
    {
        return $this->config[$key] ?? null;
    }

    public function toArray(): array
    {
        return $this->config;
    }

    public function toJson(): string
    {
        return json_encode($this->config);
    }

    public function applyToElement(string $elementId): string
    {
        $configJson = json_encode($this->toArray());
        return "<script>htmx.config.extend('#$elementId', $configJson);</script>";
    }
}
