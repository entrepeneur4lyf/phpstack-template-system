<?php

namespace phpStack\TemplateSystem\Core\Template;

class HtmxViewHelper
{
    private HtmxConfig $config;
    private HtmxComponents $htmxComponents;

    public function __construct(HtmxConfig $config, HtmxComponents $htmxComponents)
    {
        $this->config = $config;
        $this->htmxComponents = $htmxComponents;
    }

    public function renderHtmxScript(): string
    {
        return '<script src="https://unpkg.com/htmx.org@1.9.2"></script>';
    }

    public function renderHtmxConfig(): string
    {
        return '<script>htmx.config = ' . json_encode($this->config->toArray()) . ';</script>';
    }

    public function csrf(): string
    {
        return $this->htmxComponents->generateCsrfToken();
    }

    public function hxGet(string $url): string
    {
        return 'hx-get="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxPost(string $url): string
    {
        return 'hx-post="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxPut(string $url): string
    {
        return 'hx-put="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxDelete(string $url): string
    {
        return 'hx-delete="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxTrigger(string $event): string
    {
        return 'hx-trigger="' . htmlspecialchars($event, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxTarget(string $target): string
    {
        return 'hx-target="' . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxSwap(string $swapMethod): string
    {
        return 'hx-swap="' . htmlspecialchars($swapMethod, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxPushUrl(string $url): string
    {
        return 'hx-push-url="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxBoost(bool $enabled = true): string
    {
        return 'hx-boost="' . ($enabled ? 'true' : 'false') . '"';
    }

    public function hxIndicator(string $selector): string
    {
        return 'hx-indicator="' . htmlspecialchars($selector, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxConfirm(string $message): string
    {
        return 'hx-confirm="' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxVals(array $values): string
    {
        return 'hx-vals=\'' . htmlspecialchars(json_encode($values), ENT_QUOTES, 'UTF-8') . '\'';
    }

    public function hxHeaders(array $headers): string
    {
        return 'hx-headers=\'' . htmlspecialchars(json_encode($headers), ENT_QUOTES, 'UTF-8') . '\'';
    }

    public function hxInclude(string $selector): string
    {
        return 'hx-include="' . htmlspecialchars($selector, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxParams(string $params): string
    {
        return 'hx-params="' . htmlspecialchars($params, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxSync(string $sync): string
    {
        return 'hx-sync="' . htmlspecialchars($sync, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxValidate(bool $enabled = true): string
    {
        return 'hx-validate="' . ($enabled ? 'true' : 'false') . '"';
    }

    public function hxExt(string $extension): string
    {
        return 'hx-ext="' . htmlspecialchars($extension, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxOn(string $event, string $code): string
    {
        return 'hx-on:' . htmlspecialchars($event, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxEncoding(string $encoding): string
    {
        return 'hx-encoding="' . htmlspecialchars($encoding, ENT_QUOTES, 'UTF-8') . '"';
    }

    public function hxRequest(array $options): string
    {
        return 'hx-request=\'' . htmlspecialchars(json_encode($options), ENT_QUOTES, 'UTF-8') . '\'';
    }
}