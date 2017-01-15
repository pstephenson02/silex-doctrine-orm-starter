<?php
// Add the autoloader to Doctrine's AnnotationRegistry so it can load annotation mapping
$loader = require __DIR__ . '/../vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = require __DIR__ . '/../app/app.php';

$config = require __DIR__ . '/../app/config/prod.php';
foreach ($config as $key => $value) {
    $app[$key] = $value;
}

$app->run();
