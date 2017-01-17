<?php

namespace App\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

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
        $factory->post('/', 'user.controller:createUser')
            ->before(function (Request $request, Application $app) {
                $params = json_decode($request->getContent(), true);
                if (!array_key_exists('email', $params)) {
                    throw new BadRequestHttpException('You must post a valid email address');
                }
                $errors = $app['validator']->validate($params['email'], new Assert\Email());
                if (count($errors) > 0) {
                    throw new BadRequestHttpException((string) $errors);
                }
                return null;
            });
        $factory->put('/{id}', 'user.controller:updateUser')
            ->before(function (Request $request, Application $app) {
                $params = json_decode($request->getContent(), true);
                if (array_key_exists('email', $params)) {
                    $errors = $app['validator']->validate($params['email'], new Assert\Email());
                    if (count($errors) > 0) {
                        throw new BadRequestHttpException((string) $errors);
                    }
                }
                return null;
            })
            ->assert('id', '\d+');

        return $factory;
    }
}
