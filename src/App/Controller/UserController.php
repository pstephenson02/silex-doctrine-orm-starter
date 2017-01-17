<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $response = [];
        foreach ($users as $user) {
            $response[] = UserResource::transform($user);
        }
        return JsonResponse::create($response);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        return JsonResponse::create(UserResource::transform($user));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $user = $this->userRepository->create($params);
        return JsonResponse::create(UserResource::transform($user));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUser(int $id, Request $request): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException(sprintf('User %d does not exist', $id));
        }
        $params = json_decode($request->getContent(), true);
        $updated = $this->userRepository->update($user, $params);
        return JsonResponse::create(UserResource::transform($updated));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException(sprintf('User %d does not exist', $id));
        }
        $this->userRepository->delete($user);
        return new Response('', 204);
    }
}
