<?php

namespace phpStack\TemplateSystem\Core\Template;

class HtmxResponseHandler
{
    public static function addHeaders(array $response): array
    {
        $headers = [];
        
        $htmxHeaders = [
            'HX-Location',
            'HX-Push-Url',
            'HX-Redirect',
            'HX-Refresh',
            'HX-Replace-Url',
            'HX-Reswap',
            'HX-Retarget',
            'HX-Reselect',
            'HX-Trigger',
            'HX-Trigger-After-Settle',
            'HX-Trigger-After-Swap'
        ];
        
        foreach ($htmxHeaders as $header) {
            if (isset($response[$header])) {
                $headers[$header] = $response[$header];
            }
        }
        
        return $headers;
    }
}