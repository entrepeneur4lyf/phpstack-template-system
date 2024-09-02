<?php

namespace Examples\Components;

use phpStack\TemplateSystem\Core\Template\HtmxComponent;
use phpStack\TemplateSystem\Core\Template\InputComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;

class CustomSearchComponent extends HtmxComponent
{
    public static function render(array $args, array $data): string
    {
        $searchInput = InputComponent::render([
            'type' => 'text',
            'name' => 'search',
            'placeholder' => $args['placeholder'] ?? 'Search...',
            'hx-post' => $args['endpoint'] ?? '/api/search',
            'hx-trigger' => 'keyup changed delay:500ms',
            'hx-target' => '#search-results',
            'hx-indicator' => '.htmx-indicator'
        ], []);

        $searchResults = DivComponent::render([
            'id' => 'search-results',
            'content' => '<p>Type to search...</p>'
        ], []);

        $loadingIndicator = DivComponent::render([
            'class' => 'htmx-indicator',
            'content' => 'Searching...',
            'style' => 'display:none;'
        ], []);

        return $searchInput . $loadingIndicator . $searchResults;
    }
}