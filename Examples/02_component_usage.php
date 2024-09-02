<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpStack\TemplateSystem\Core\Template\TemplateEngine;
use phpStack\TemplateSystem\Core\Template\PerformanceProfiler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$templateDir = __DIR__ . '/templates';
$profiler = new PerformanceProfiler();
$cache = new FilesystemAdapter();

$engine = new TemplateEngine($templateDir, $profiler, $cache);

// Register a component
$engine->registerComponent('user-profile', function($args, $data) {
    $name = $data['name'] ?? 'Guest';
    $email = $data['email'] ?? 'N/A';
    return "<div class=\"user-profile\">
                <h2>{$name}</h2>
                <p>Email: {$email}</p>
            </div>";
});

// Create a template that uses the component
file_put_contents(__DIR__ . '/templates/profile_page.php', '
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <?php echo $this->renderComponent("user-profile", ["name" => $name, "email" => $email]); ?>
</body>
</html>
');

// Render the template
$data = ['name' => 'John Doe', 'email' => 'john@example.com'];
$rendered = $engine->render('profile_page.php', $data);

echo $rendered;