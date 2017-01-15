<?php

namespace App;

use App\Command\UserSeeder;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Version;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Class ConsoleRunner
 * @package App
 */
class ConsoleRunner extends \Doctrine\ORM\Tools\Console\ConsoleRunner
{
    /**
     * {@inheritdoc}
     */
    public static function createHelperSet(EntityManagerInterface $entityManager): HelperSet
    {
        return new HelperSet(
            [
                'db' => new ConnectionHelper($entityManager->getConnection()),
                'em' => new EntityManagerHelper($entityManager),
                'question' => new QuestionHelper()
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    static public function addCommands(Application $cli)
    {
        parent::addCommands($cli);
        $cli->addCommands(
            [
                new UserSeeder()
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    static public function createApplication(HelperSet $helperSet, $commands = array()): Application
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);
        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);
        self::addCommands($cli);
        $cli->addCommands($commands);

        return $cli;
    }
}
