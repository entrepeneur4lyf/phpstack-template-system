<?php
$examples = [
    'htmx_basic_example.php' => 'Basic HTMX Example',
    'htmx_advanced_example.php' => 'Advanced HTMX Example',
    'htmx_advanced_features.php' => 'HTMX Advanced Features',
    'htmx_live_search.php' => 'HTMX Live Search Example',
    'htmx_complex_example.php' => 'Complex HTMX Example',
    'custom_components_example.php' => 'Custom HTMX Components Example',
    'markdown_plugin_example.php' => 'Markdown Plugin Example',
];

echo "<h1>HTMX Integration Examples</h1>";
echo "<ul>";
foreach ($examples as $file => $description) {
    echo "<li><a href='{$file}'>{$description}</a></li>";
}
echo "</ul>";