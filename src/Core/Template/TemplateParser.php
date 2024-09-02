<?php

namespace phpStack\TemplateSystem\Core\Template;

class TemplateParser
{
    public function parse(string $template): array
    {
        $parts = [];
        $regex = '/\{\[((?:[^{}]|\{(?!\[)|\}(?!\]))*)\]\}/';
        $offset = 0;

        while (preg_match($regex, $template, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $fullMatch = $matches[0];
            $innerMatch = $matches[1];

            // Add the text before the tag
            if ($fullMatch[1] > $offset) {
                $parts[] = [
                    'type' => 'text',
                    'content' => substr($template, $offset, $fullMatch[1] - $offset)
                ];
            }

            // Parse the tag content
            $parts[] = $this->parseTag(trim($innerMatch[0]));

            $offset = $fullMatch[1] + strlen($fullMatch[0]);
        }

        // Add any remaining text after the last tag
        if ($offset < strlen($template)) {
            $parts[] = [
                'type' => 'text',
                'content' => substr($template, $offset)
            ];
        }

        return $parts;
    }

    private function parseTag(string $tagContent): array
    {
        $parts = explode('|', $tagContent);
        $mainPart = array_shift($parts);

        preg_match('/(\w+)\((.*)\)/', $mainPart, $matches);
        $pluginName = $matches[1];
        $args = $this->parseArgs($matches[2]);

        return [
            'type' => 'plugin',
            'name' => $pluginName,
            'args' => $args,
            'chain' => array_map([$this, 'parseChainedPlugin'], $parts)
        ];
    }

    private function parseArgs(string $argsString): array
    {
        $args = [];
        $regex = '/(\w+)(?:=([^,]+))?/';
        preg_match_all($regex, $argsString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $key = $match[1];
            $value = $match[2] ?? null;
            $args[$key] = trim($value, '"\'');
        }

        return $args;
    }

    private function parseChainedPlugin(string $chainedPlugin): array
    {
        preg_match('/(\w+)\((.*)\)/', $chainedPlugin, $matches);
        $pluginName = $matches[1];
        $args = $this->parseArgs($matches[2]);

        return [
            'name' => $pluginName,
            'args' => $args
        ];
    }
}