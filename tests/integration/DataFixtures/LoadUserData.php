<?php

namespace tests\integration\DataFixtures;

use App\Model\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserData
 * @package tests\integration\DataFixtures
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    const FIXTURE_PREFIX = 'user_';
    const USER_ID = '1';

    /**
     * @param ObjectManager $om
     */
    public function load(ObjectManager $om)
    {
        $user = new User();
        $user->setId(1);
        $user->setEmail('bob@loblaw.com');
        $om->persist($user);

        $user2 = new User();
        $user2->setId(2);
        $user2->setEmail('tobias@arresteddevelopment.com');
        $om->persist($user2);

        $om->flush();

        $this->addReference(self::FIXTURE_PREFIX . self::USER_ID, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return FixtureOrderMap::$fixtureMap[get_class($this)];
    }
}
