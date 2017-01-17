<?php

$app = new Silex\Application();

$app->register(new Silex\Provider\HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());

$app->mount('/user', new \App\Provider\UserControllerProvider());

$app['user.controller'] = function () use ($app) {
    $userRepository = $app['orm.em']->getRepository(\App\Model\User::class);
    return new \App\Controller\UserController($userRepository);
};

$app->before(function (\Symfony\Component\HttpFoundation\Request $request) {
    if ($request->isMethod('POST') || $request->isMethod('PUT')) {
        if (0 !== strpos($request->headers->get('Content-Type'), 'application/json')) {
            throw new \RuntimeException(
                sprintf('You must call %s with Content-Type: application/json', $request->getPathInfo())
            );
        }
    }
});

return $app;
