<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

// Create the template file
file_put_contents(__DIR__ . '/templates/hello.php', '<?php echo "Hello, {$name}!"; ?>');

$templateDir = __DIR__ . '/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Render the template
$data = ['name' => 'World'];
$rendered = $engine->render('hello.php', $data);

echo $rendered . "\n";

// Display profiling information
$metrics = $profiler->getAllProfiles();
foreach ($metrics as $name => $duration) {
    echo "{$name}: {$duration} seconds\n";
}