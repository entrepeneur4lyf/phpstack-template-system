<?php

namespace phpStack\TemplateSystem\Examples\Plugins;

use phpStack\TemplateSystem\Core\Plugins\HtmxPluginInterface;

class MarkdownPlugin implements HtmxPluginInterface
{
    private $htmlToMarkdownMap = [
        'h1' => '# ',
        'h2' => '## ',
        'h3' => '### ',
        'h4' => '#### ',
        'h5' => '##### ',
        'h6' => '###### ',
        'strong' => '**',
        'em' => '*',
        'code' => '`',
        'pre' => '```',
        'a' => '[%s](%s)',
        'ul' => '',
        'ol' => '',
        'li' => '- ',
    ];
    public function processHtmxContent(string $content): string
    {
        return preg_replace_callback('/\{\{markdown\}\}(.*?)\{\{\/markdown\}\}/s', function($matches) {
            return $this->parseMarkdown($matches[1]);
        }, $content);
    }

    private function parseMarkdown(string $markdown): string
    {
        // Escape special characters
        $markdown = $this->escapeSpecialCharacters($markdown);

        // Headers
        $markdown = preg_replace('/^######\s(.+)$/m', '<h6>$1</h6>', $markdown);
        $markdown = preg_replace('/^#####\s(.+)$/m', '<h5>$1</h5>', $markdown);
        $markdown = preg_replace('/^####\s(.+)$/m', '<h4>$1</h4>', $markdown);
        $markdown = preg_replace('/^###\s(.+)$/m', '<h3>$1</h3>', $markdown);
        $markdown = preg_replace('/^##\s(.+)$/m', '<h2>$1</h2>', $markdown);
        $markdown = preg_replace('/^#\s(.+)$/m', '<h1>$1</h1>', $markdown);

        // Bold and Italic
        $markdown = preg_replace('/\*\*\*(.+?)\*\*\*/s', '<strong><em>$1</em></strong>', $markdown);
        $markdown = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $markdown);
        $markdown = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $markdown);

        // Strikethrough
        $markdown = preg_replace('/~~(.+?)~~/s', '<del>$1</del>', $markdown);

        // Superscript
        $markdown = preg_replace('/\^(.+?)\^/s', '<sup>$1</sup>', $markdown);

        // Lists
        $markdown = preg_replace_callback('/(?:^|\n)([*+-])\s(.+)(?:\n|$)/m', function($matches) {
            return "\n<ul>\n<li>" . $matches[2] . "</li>\n</ul>\n";
        }, $markdown);
        $markdown = preg_replace_callback('/(?:^|\n)(\d+\.)\s(.+)(?:\n|$)/m', function($matches) {
            return "\n<ol>\n<li>" . $matches[2] . "</li>\n</ol>\n";
        }, $markdown);

        // Links
        $markdown = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $markdown);

        // Images
        $markdown = preg_replace('/!\[([^\]]+)\]\(([^\)]+)\)/', '<img src="$2" alt="$1">', $markdown);

        // Blockquotes
        $markdown = preg_replace('/^\>\s(.+)$/m', '<blockquote>$1</blockquote>', $markdown);

        // Code blocks
        $markdown = preg_replace_callback('/```(.+?)```/s', function($matches) {
            return '<pre><code>' . htmlspecialchars($matches[1]) . '</code></pre>';
        }, $markdown);

        // Inline code
        $markdown = preg_replace('/`(.+?)`/', '<code>$1</code>', $markdown);

        // Horizontal rule
        $markdown = preg_replace('/^---$/m', '<hr>', $markdown);

        // Tables
        $markdown = preg_replace_callback('/\|(.+)\|/m', function($matches) {
            $cells = explode('|', trim($matches[1]));
            $cells = array_map('trim', $cells);
            return '<tr><td>' . implode('</td><td>', $cells) . '</td></tr>';
        }, $markdown);
        $markdown = preg_replace('/^<tr>/', '<table><tr>', $markdown);
        $markdown = preg_replace('/<\/tr>$/', '</tr></table>', $markdown);

        // Paragraphs
        $markdown = '<p>' . preg_replace('/\n\s*\n/', '</p><p>', $markdown) . '</p>';

        // Unescape special characters
        $markdown = $this->unescapeSpecialCharacters($markdown);

        return $markdown;
    }

    private function escapeSpecialCharacters(string $text): string
    {
        $specialChars = [
            '\\' => '&#92;',
            '*' => '&#42;',
            '_' => '&#95;',
            '{' => '&#123;',
            '}' => '&#125;',
            '[' => '&#91;',
            ']' => '&#93;',
            '(' => '&#40;',
            ')' => '&#41;',
            '#' => '&#35;',
            '+' => '&#43;',
            '-' => '&#45;',
            '.' => '&#46;',
            '!' => '&#33;',
            '`' => '&#96;',
        ];

        return preg_replace_callback('/\\\\([\\\\*_{}\[\]()#+\-.!`])/', function($matches) use ($specialChars) {
            return $specialChars[$matches[1]] ?? $matches[0];
        }, $text);
    }

    private function unescapeSpecialCharacters(string $text): string
    {
        $specialChars = [
            '&#92;' => '\\',
            '&#42;' => '*',
            '&#95;' => '_',
            '&#123;' => '{',
            '&#125;' => '}',
            '&#91;' => '[',
            '&#93;' => ']',
            '&#40;' => '(',
            '&#41;' => ')',
            '&#35;' => '#',
            '&#43;' => '+',
            '&#45;' => '-',
            '&#46;' => '.',
            '&#33;' => '!',
            '&#96;' => '`',
        ];

        return str_replace(array_keys($specialChars), array_values($specialChars), $text);
    }

    public function execute(array $args, array $data) { /* ... */ }
    public function getDependencies(): array { return []; }
    public function applyToComponent(string $name, array $options): string { return ''; }
}
