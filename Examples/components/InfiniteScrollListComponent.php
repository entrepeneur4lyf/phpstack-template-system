<?php

namespace Examples\Components;

use phpStack\TemplateSystem\Core\Template\HtmxComponent;
use phpStack\TemplateSystem\Core\Template\DivComponent;

class InfiniteScrollListComponent extends HtmxComponent
{
    public static function render(array $args, array $data): string
    {
        $listContainer = DivComponent::render([
            'id' => $args['id'] ?? 'infinite-scroll-list',
            'hx-trigger' => 'revealed',
            'hx-get' => $args['endpoint'] ?? '/api/more-items',
            'hx-swap' => 'beforeend',
            'hx-indicator' => '.htmx-indicator',
            'content' => $args['initial_content'] ?? '<div>Loading initial content...</div>'
        ], []);

        $loadingIndicator = DivComponent::render([
            'class' => 'htmx-indicator',
            'content' => 'Loading more...',
            'style' => 'display:none;'
        ], []);

        return $listContainer . $loadingIndicator;
    }
}