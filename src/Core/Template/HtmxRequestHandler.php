<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class HtmxRequestHandler
 *
 * Handles HTMX requests within the template system.
 */
class HtmxRequestHandler
{
    public static function handle(array $request): array
    {
        $headers = [];
        
        $htmxHeaders = [
            'HX-Boosted',
            'HX-Current-URL',
            'HX-History-Restore-Request',
            'HX-Prompt',
            'HX-Request',
            'HX-Target',
            'HX-Trigger-Name',
            'HX-Trigger'
        ];
        
        foreach ($htmxHeaders as $header) {
            if (isset($request[$header])) {
                $headers[$header] = $request[$header];
            }
        }
        
        return $headers;
    }
}
