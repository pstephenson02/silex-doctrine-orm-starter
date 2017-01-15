<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        return JsonResponse::create($user);
    }
}
