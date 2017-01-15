<?php

use App\ConsoleRunner;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = require_once __DIR__ . '/../app/app.php';
$config = require_once __DIR__ . '/../app/config/prod.php';
foreach ($config as $key => $value) {
    $app[$key] = $value;
}

$helperSet = ConsoleRunner::createHelperSet($app['orm.em']);
$cli = ConsoleRunner::createApplication($helperSet);
$cli->run();
