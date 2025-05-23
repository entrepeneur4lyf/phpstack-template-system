<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class HtmxComponent
 *
 * Represents an HTMX component within the template system.
 */
abstract class HtmxComponent extends HtmxBaseComponent
{
    /**
     * Adds HTMX attributes to the given arguments array.
     *
     * @param array<string, mixed> $args The arguments array to modify.
     */
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
