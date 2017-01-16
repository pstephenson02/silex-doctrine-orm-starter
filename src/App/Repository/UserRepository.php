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

}
