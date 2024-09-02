# Tutorial 5: HTMX Documentation Scraper

This tutorial demonstrates how to use the enhanced MarkupPlugin to scrape HTML content from the HTMX documentation website and convert it to Markdown format.

## Step 1: Set up the necessary components

First, let's set up the TemplateEngine and MarkdownPlugin:

```php
use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\TemplateParser;
use phpStack\TemplateSystem\Core\Template\TemplateRenderer;
use phpStack\TemplateSystem\Core\Plugins\PluginManager;
use phpStack\TemplateSystem\Core\Template\Plugins\UserPlugins\MarkdownPlugin;

$parser = new TemplateParser();
$pluginManager = new PluginManager();
$renderer = new TemplateRenderer($pluginManager);
$templateEngine = new TemplateEngine($parser, $renderer);

$markdownPlugin = new MarkdownPlugin();
$pluginManager->registerPlugin('markdown', $markdownPlugin, '1.0.0');
```

## Step 2: Create a function to fetch HTML content

Let's create a function to fetch the HTML content from the HTMX documentation website:

```php
function fetchHtmlContent(string $url): string
{
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
        ]
    ];
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
}
```

## Step 3: Scrape and convert the HTMX documentation

Now, let's use our `fetchHtmlContent` function and the MarkdownPlugin to scrape and convert the HTMX documentation:

```php
$url = 'https://htmx.org/docs/';
$html = fetchHtmlContent($url);

// Extract the main content (you may need to adjust this based on the page structure)
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$mainContent = $xpath->query('//main')->item(0);

if ($mainContent) {
    $htmlContent = $dom->saveHTML($mainContent);
    $markdown = $markdownPlugin->htmlToMarkdown($htmlContent);

    // Save the markdown content to a file
    file_put_contents('htmx_docs.md', $markdown);

    echo "HTMX documentation has been scraped and converted to Markdown. Check 'htmx_docs.md' for the result.";
} else {
    echo "Failed to extract main content from the HTMX documentation page.";
}
```

## Step 4: Use the converted content in a template

Finally, let's create a template that uses the converted Markdown content:

```php
$template = "
<h1>HTMX Documentation</h1>
<div class='markdown-content'>
    {[markdown content=file_get_contents('htmx_docs.md')]}
</div>
";

$result = $templateEngine->render($template);
echo $result;
```

This tutorial demonstrates how to:

1. Set up the TemplateEngine and MarkdownPlugin
2. Fetch HTML content from a website
3. Use the enhanced MarkdownPlugin to convert HTML to Markdown
4. Save the converted content to a file
5. Use the converted content in a template

By following these steps, you can easily scrape and convert documentation or other HTML content to Markdown format, which can then be used within your templates.
