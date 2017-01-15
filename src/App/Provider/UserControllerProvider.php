<?php

namespace App\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

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
        $factory->get('/{id}', 'user.controller:getUser');

        return $factory;
    }
}
