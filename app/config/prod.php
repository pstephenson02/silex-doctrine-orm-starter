<?php

if (!file_exists(__DIR__.'/../parameters.php')) {
    throw new RuntimeException('You must define app parameters. See app/parameters.php.dist');
}

$parameters = require __DIR__.'/../parameters.php';

return [
    'debug' => isset($parameters['debug']) ? $parameters['debug'] : false,
    'db.options' => [
        'driver'   => 'pdo_mysql',
        'host'     => $parameters['mysql']['host'],
        'dbname'   => $parameters['mysql']['database'],
        'user'     => $parameters['mysql']['username'],
        'password' => $parameters['mysql']['password'],
        'charset'  => 'utf8mb4',
    ],
    'orm.proxies_dir' => __DIR__.'/../../var/cache/doctrine/orm/Proxies',
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'App\Model',
                'path' => __DIR__.'/../../src/App/Model'
            ],
        ],
    ]
];
