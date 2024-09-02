<?php

namespace phpStack\TemplateSystem\Core\Template;

abstract class HtmxComponent extends HtmxBaseComponent
{
    protected static function addHtmxAttributes(array &$args): void
    {
        $htmxAttributes = [
            'hx-get', 'hx-post', 'hx-put', 'hx-delete', 'hx-patch',
            'hx-trigger', 'hx-target', 'hx-swap', 'hx-push-url',
            'hx-select', 'hx-select-oob', 'hx-swap-oob', 'hx-boost',
            'hx-confirm', 'hx-disable', 'hx-encoding', 'hx-ext',
            'hx-headers', 'hx-history-elt', 'hx-include', 'hx-indicator',
            'hx-params', 'hx-preserve', 'hx-prompt', 'hx-request',
            'hx-sync', 'hx-validate', 'hx-vars', 'hx-ws'
        ];

        foreach ($htmxAttributes as $attr) {
            if (isset($args[$attr])) {
                $args[$attr] = $attr . '="' . htmlspecialchars($args[$attr], ENT_QUOTES, 'UTF-8') . '"';
            }
        }
    }
}