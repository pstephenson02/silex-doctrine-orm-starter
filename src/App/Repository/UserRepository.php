<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Model\User;

/**
 * Class UserRepository
 * @package App\Repository
 * @method User find($id, $lockMode = null, $lockVersion = null)
 */
class UserRepository extends EntityRepository
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->update(new User(), $data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        if (array_key_exists('email', $data)) {
            $user->setEmail($data['email']);
        }
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
