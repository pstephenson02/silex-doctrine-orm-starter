<?php

namespace App\Resource;

use App\Model\User;

/**
 * Class UserResource
 * @package App\Resource
 */
class UserResource
{
    /**
     * @param User $user
     * @return array
     */
    public static function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ];
    }
}
