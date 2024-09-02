<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$templateDir = __DIR__ . '/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Create a template with a time-consuming operation
file_put_contents(__DIR__ . '/templates/slow_template.php', '
<?php
$result = 0;
for ($i = 0; $i < 1000000; $i++) {
    $result += $i;
}
echo "The result is: {$result}";
?>
');

// Render the template multiple times to demonstrate caching
echo "First render (uncached):\n";
$start = microtime(true);
$rendered = $engine->render('slow_template.php', []);
$end = microtime(true);
echo $rendered . "\n";
echo "Time taken: " . ($end - $start) . " seconds\n\n";

echo "Second render (cached):\n";
$start = microtime(true);
$rendered = $engine->render('slow_template.php', []);
$end = microtime(true);
echo $rendered . "\n";
echo "Time taken: " . ($end - $start) . " seconds\n\n";

// Display profiling information
echo "Profiling information:\n";
$metrics = $profiler->getAllProfiles();
foreach ($metrics as $name => $duration) {
    echo "{$name}: {$duration} seconds\n";
}