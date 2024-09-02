<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class HtmxBaseComponent
 *
 * Base class for HTMX components providing common functionality.
 */
abstract class HtmxBaseComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    abstract public static function render(array $args, array $data): string;

    /**
     * @param array<string, mixed> $args
     */
    protected static function buildAttributes(array $args): string
    {
        $attributes = [];
        foreach ($args as $key => $value) {
            if ($key !== 'tag' && $key !== 'content' && $value !== null) {
                $attributes[] = $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        return $attributes ? ' ' . implode(' ', $attributes) : '';
    }

    /**
     * @param array<string, mixed> $args
     */
    protected static function buildHtmxClasses(array $args): string
    {
        $htmxClasses = array_intersect_key($args, array_flip([
            'htmx-added', 'htmx-indicator', 'htmx-request', 'htmx-settling', 'htmx-swapping'
        ]));
        return $htmxClasses ? ' ' . implode(' ', array_keys($htmxClasses)) : '';
    }

    /**
     * @param array<string, mixed> $args
     */
    protected static function buildHtmxAttributes(array $args): string
    {
        $htmxAttributes = [];
        $simpleAttributes = ['hx-boost', 'hx-push-url', 'hx-select', 'hx-select-oob', 'hx-swap-oob', 'hx-target', 'hx-trigger', 'hx-vals', 'hx-confirm', 'hx-delete', 'hx-encoding', 'hx-ext', 'hx-headers', 'hx-history', 'hx-history-elt', 'hx-include', 'hx-indicator', 'hx-params', 'hx-preserve', 'hx-prompt', 'hx-replace-url', 'hx-request', 'hx-sse', 'hx-swap', 'hx-sync', 'hx-validate', 'hx-vars', 'hx-ws'];
        
        foreach ($simpleAttributes as $attr) {
            if (isset($args[$attr])) {
                $htmxAttributes[] = $attr . '="' . htmlspecialchars($args[$attr], ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        
        if (isset($args['hx-disable'])) {
            $htmxAttributes[] = 'hx-disable';
        }
        
        if (isset($args['hx-disinherit'])) {
            $htmxAttributes[] = 'hx-disinherit="' . htmlspecialchars($args['hx-disinherit'], ENT_QUOTES, 'UTF-8') . '"';
        }
        
        return $htmxAttributes ? ' ' . implode(' ', $htmxAttributes) : '';
    }
}

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

class ElementComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $tag = $args['tag'] ?? 'div';
        $content = $args['content'] ?? '';
        $attributes = self::buildAttributes($args);
        $htmxClasses = self::buildHtmxClasses($args);
        $htmxAttributes = self::buildHtmxAttributes($args);
        
        // Combine existing classes with HTMX classes
        $existingClasses = isset($args['class']) ? $args['class'] . ' ' : '';
        $classes = trim($existingClasses . $htmxClasses);
        
        $classAttribute = $classes ? " class=\"{$classes}\"" : '';

        return "<{$tag}{$classAttribute} {$attributes} {$htmxAttributes}>{$content}</{$tag}>";
    }
}

class ButtonComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $text = $args['text'] ?? 'Click me';
        $attributes = self::buildAttributes($args);

        return "<button {$attributes}>{$text}</button>";
    }
}

class FormComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $content = $args['content'] ?? '';
        $attributes = self::buildAttributes($args);

        return "<form {$attributes}>{$content}</form>";
    }
}

class SelectComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $name = $args['name'] ?? 'select';
        $options = $args['options'] ?? [];
        $attributes = self::buildAttributes($args);

        $optionsHtml = '';
        foreach ($options as $value => $label) {
            $optionsHtml .= "<option value=\"" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</option>";
        }

        return "<select name=\"{$name}\" {$attributes}>{$optionsHtml}</select>";
    }
}

class InputComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $name = $args['name'] ?? 'input';
        $type = $args['type'] ?? 'text';
        $attributes = self::buildAttributes($args);

        return "<input type=\"{$type}\" name=\"{$name}\" {$attributes}>";
    }
}

class DivComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $content = $args['content'] ?? '';
        $attributes = self::buildAttributes($args);

        return "<div {$attributes}>{$content}</div>";
    }
}

class AnchorComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $text = $args['text'] ?? 'Link';
        $href = $args['href'] ?? '#';
        $attributes = self::buildAttributes($args);

        return "<a href=\"{$href}\" {$attributes}>{$text}</a>";
    }
}

class InlineValidationComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $name = $args['name'] ?? 'field';
        $attributes = self::buildAttributes($args);

        return "<input name=\"{$name}\" {$attributes}>
                <div class=\"error-message\" id=\"{$name}-error\"></div>
                <script>
                    document.querySelector('input[name=\"{$name}\"]').addEventListener('blur', function() {
                        htmx.trigger(this, 'validate');
                    });
                </script>";
    }
}

class InfiniteScrollComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $url = $args['url'] ?? '';
        $target = $args['target'] ?? 'this';
        $attributes = self::buildAttributes($args);

        return "<div {$attributes} hx-trigger=\"revealed\" hx-get=\"{$url}\" hx-target=\"{$target}\"></div>";
    }
}

class ModalComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $id = $args['id'] ?? 'modal';
        $triggerText = $args['triggerText'] ?? 'Open Modal';
        $content = $args['content'] ?? '';
        $attributes = self::buildAttributes($args);

        return "
            <button hx-get=\"#$id\" hx-target=\"body\" hx-swap=\"beforeend\">{$triggerText}</button>
            <div id=\"$id\" class=\"modal\" style=\"display:none;\" {$attributes}>
                <div class=\"modal-content\">
                    {$content}
                    <button hx-get=\"#\" hx-target=\"closest .modal\" hx-swap=\"outerHTML\">Close</button>
                </div>
            </div>
        ";
    }
}

class EventListenerComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $event = $args['event'] ?? '';
        $handler = $args['handler'] ?? '';
        
        return "<script>
            document.body.addEventListener('htmx:$event', function(evt) {
                $handler
            });
        </script>";
    }
}

class LoggerComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $logLevel = $args['level'] ?? 'info';
        $message = $args['message'] ?? '';
        
        return "<script>
            console.$logLevel('HTMX Log: $message');
        </script>";
    }
}

class BoostComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $content = $args['content'] ?? '';
        $boost = isset($args['boost']) ? (bool)$args['boost'] : true;
        $attributes = self::buildAttributes($args);
        $boostAttribute = $boost ? 'hx-boost="true"' : '';

        return "<div {$attributes} {$boostAttribute}>{$content}</div>";
    }
}

class PaginationComponent extends HtmxComponent
{
    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     */
    public static function render(array $args, array $data): string
    {
        self::addHtmxAttributes($args);
        $currentPage = $args['currentPage'] ?? 1;
        $totalPages = $args['totalPages'] ?? 1;
        $baseUrl = $args['baseUrl'] ?? '#';
        $attributes = self::buildAttributes($args);

        $pagination = "<nav {$attributes}><ul class='pagination'>";

        // Previous button
        $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
        $prevUrl = $currentPage > 1 ? "{$baseUrl}?page=" . ($currentPage - 1) : '#';
        $pagination .= "<li class='page-item {$prevDisabled}'><a class='page-link' href='{$prevUrl}' hx-get='{$prevUrl}' hx-target='#content-container'>Previous</a></li>";

        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i === $currentPage ? 'active' : '';
            $url = "{$baseUrl}?page={$i}";
            $pagination .= "<li class='page-item {$active}'><a class='page-link' href='{$url}' hx-get='{$url}' hx-target='#content-container'>{$i}</a></li>";
        }

        // Next button
        $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
        $nextUrl = $currentPage < $totalPages ? "{$baseUrl}?page=" . ($currentPage + 1) : '#';
        $pagination .= "<li class='page-item {$nextDisabled}'><a class='page-link' href='{$nextUrl}' hx-get='{$nextUrl}' hx-target='#content-container'>Next</a></li>";

        $pagination .= "</ul></nav>";

        return $pagination;
    }
}
