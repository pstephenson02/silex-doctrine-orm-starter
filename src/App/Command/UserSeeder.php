<?php

namespace App\Command;

use App\Model\User;
use App\Helpers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class UserSeeder
 * @package App\Command
 */
class UserSeeder extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('orm:seed:users')
            ->setDescription('Seed your database with users.');
        $this->setHelp('The <info>%command.name%</info> command is meant to seed your database with users.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getHelper('em')->getEntityManager();
        $questionHelper = $this->getHelper('question');

        $question = new Question('How many users would you like to create? ');
        $question->setNormalizer(function ($value) {
            return $value ? (int) $value : 0;
        });
        $question->setValidator(function ($answer) {
            if ($answer <= 0) {
                throw new \RuntimeException('You must choose some value greater than zero.');
            }
            return $answer;
        });
        $userCount = $questionHelper->ask($input, $output, $question);

        for ($i = 0; $i < $userCount; $i++) {
            $user = new User();
            $user->setEmail(Helpers::quickRandom(8) . '@example.com');

            $em->persist($user);
        }

        $em->flush();
        $output->writeln('Successfully generated ' . $userCount . ' new users!');
    }
}
