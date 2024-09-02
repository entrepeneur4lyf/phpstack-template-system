<?php

namespace phpStack\Core\Template\Plugins;

use phpStack\Core\Template\PluginInterface;
use phpStack\Core\Template\TemplateEngine;

class ForPlugin implements PluginInterface
{
    private $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function execute(array $args, array $data)
    {
        $items = $args['items'] ?? null;
        $as = $args['as'] ?? 'item';
        $template = $args['template'] ?? null;
        $keyAs = $args['key_as'] ?? 'key';
        $indexAs = $args['index_as'] ?? 'index';
        $emptyTemplate = $args['empty_template'] ?? null;

        if ($items === null || $template === null) {
            throw new \RuntimeException("For plugin requires 'items' and 'template' arguments");
        }

        $itemsArray = $this->getItemsArray($items, $data);

        if (empty($itemsArray) && $emptyTemplate !== null) {
            return $this->templateEngine->render($emptyTemplate, $data);
        }

        $output = '';
        $index = 0;

        foreach ($itemsArray as $key => $item) {
            $itemData = [
                $as => $item,
                $keyAs => $key,
                $indexAs => $index,
            ] + $data;
            $output .= $this->templateEngine->render($template, $itemData);
            $index++;
        }

        return $output;
    }

    private function getItemsArray($items, array $data)
    {
        if (is_string($items) && isset($data[$items])) {
            return $data[$items];
        }
        if ($items instanceof \Traversable) {
            return iterator_to_array($items);
        }
        return is_array($items) ? $items : [];
    }

    public function getHooks(): array
    {
        return [
            'beforeLoop' => [$this, 'beforeLoopHook'],
            'afterLoop' => [$this, 'afterLoopHook'],
        ];
    }

    public function beforeLoopHook(array &$itemsArray, array $args)
    {
        // Hook logic before the loop starts
        if (isset($args['filter'])) {
            $itemsArray = array_filter($itemsArray, $args['filter']);
        }
        if (isset($args['sort'])) {
            usort($itemsArray, $args['sort']);
        }
    }

    public function afterLoopHook(string &$output, array $args)
    {
        // Hook logic after the loop ends
        if (isset($args['wrapper'])) {
            $output = sprintf($args['wrapper'], $output);
        }
    }
}
