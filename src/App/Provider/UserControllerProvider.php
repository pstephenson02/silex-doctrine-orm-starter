<?php

namespace App\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserControllerProvider
 * @package App\Provider
 */
class UserControllerProvider implements ControllerProviderInterface
{
    /**
     * @param Application $app
     * @return ControllerCollection
     */
    public function connect(Application $app): ControllerCollection
    {
        /**
         * @var ControllerCollection $factory
         */
        $factory = $app['controllers_factory'];
        $factory->get('/', 'user.controller:getUsers');
        $factory->get('/{id}', 'user.controller:getUser')
            ->assert('id', '\d+');
        $factory->put('/{id}', 'user.controller:updateUser')
            ->assert('id', '\d+')
            ->before(function (Request $request) {
                if (0 !== strpos($request->headers->get('Content-Type'), 'application/json')) {
                    throw new \RuntimeException(
                        sprintf('You must call %s with Content-Type: application/json', $request->getPathInfo())
                    );
                }
            });

        return $factory;
    }
}
