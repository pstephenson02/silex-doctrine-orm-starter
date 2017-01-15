<?php

$app = new Silex\Application();

$app->register(new Silex\Provider\HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());

$app->mount('/user', new \App\Provider\UserControllerProvider());

$app['user.controller'] = function () use ($app) {
    $userRepository = $app['orm.em']->getRepository(\App\Model\User::class);
    return new \App\Controller\UserController($userRepository);
};

return $app;
