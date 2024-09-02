<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use phpStack\TemplateSystem\Core\Template\Plugins\UserPlugins\MarkdownPlugin;

function fetchHtmlContent(string $url): string
{
    $client = new Client();
    $response = $client->get($url);
    return $response->getBody()->getContents();
}

$url = 'https://htmx.org/docs/';
$html = fetchHtmlContent($url);

// Extract the main content
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$mainContent = $xpath->query('//div[@class="container"]')->item(0);

if ($mainContent) {
    $htmlContent = $dom->saveHTML($mainContent);
    
    $markdownPlugin = new MarkdownPlugin();
    $markdown = $markdownPlugin->htmlToMarkdown($htmlContent);

    // Save the markdown content to a file
    file_put_contents('htmx_docs.md', $markdown);

    echo "HTMX documentation has been scraped and converted to Markdown. Check 'htmx_docs.md' for the result.";
} else {
    echo "Failed to extract main content from the HTMX documentation page.";
    
    // Fallback: try to get the entire body content
    $bodyContent = $xpath->query('//body')->item(0);
    if ($bodyContent) {
        $htmlContent = $dom->saveHTML($bodyContent);
        
        $markdownPlugin = new MarkdownPlugin();
        $markdown = $markdownPlugin->htmlToMarkdown($htmlContent);

        // Save the markdown content to a file
        file_put_contents('htmx_docs.md', $markdown);

        echo " Fallback: Extracted body content instead.";
    } else {
        echo " Failed to extract any content from the page.";
    }
}
