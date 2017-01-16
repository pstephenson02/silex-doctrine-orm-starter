<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use App\Model\User;
use App\Model\UserHistory;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserSubscriber
 * @package App\EventListener
 */
class UserSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [ Events::onFlush ];
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $em->getEventManager()->removeEventSubscriber($this);
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof User) {
                $history = $this->createHistory($entity);
                $metadata = $em->getClassMetadata(get_class($entity));
                $em->persist($history);
                $em->flush();
                $uow->recomputeSingleEntityChangeSet($metadata, $entity);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof User) {
                $history = $this->createHistory($entity);
                $metadata = $em->getClassMetadata(get_class($entity));
                $em->persist($history);
                $em->flush();
                $uow->recomputeSingleEntityChangeSet($metadata, $entity);
            }
        }

        $em->getEventManager()->addEventSubscriber($this);
    }

    /**
     * @param User $user
     * @return UserHistory
     */
    private function createHistory(User $user): UserHistory
    {
        return new UserHistory(
            $user,
            $user->getEmail()
        );
    }
}
