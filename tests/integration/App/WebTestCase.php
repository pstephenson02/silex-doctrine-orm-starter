<?php

namespace tests\integration\App;

use App\Model\UserHistory;
use App\EventListener\UserSubscriber;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Id\IdentityGenerator;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class WebTestCase
 * @package tests\integration\App
 */
class WebTestCase extends \Silex\WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function createApplication()
    {
        $loader = require __DIR__ . '/../../../vendor/autoload.php';
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);

        $app = require __DIR__ . '/../../../app/app.php';
        $config = require __DIR__.'/../../../app/config/test.php';
        foreach ($config as $key => $value) {
            $app[$key] = $value;
        }
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $app['orm.em'];
        $em->getEventManager()->addEventSubscriber(new UserSubscriber());

        return $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        /** @var EntityManager $em */
        $em = $this->app['orm.em'];
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        /** @var ClassMetadata[] $metadata */
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        foreach ($metadata as $md) {
            if ($md->getName() !== UserHistory::class) {
                $md->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
                $md->setIdGenerator(new AssignedGenerator());
            }
        }

        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__.'/../DataFixtures');
        $executor = new ORMExecutor($em, new ORMPurger());
        $executor->execute($loader->getFixtures());

        foreach ($metadata as $md) {
            if ($md->getName() !== UserHistory::class) {
                $md->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
                $md->setIdGenerator(new IdentityGenerator());
            }
        }
    }
}
