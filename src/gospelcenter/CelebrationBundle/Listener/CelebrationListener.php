<?php

namespace gospelcenter\CelebrationBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use gospelcenter\CelebrationBundle\Entity\Celebration;
use gospelcenter\DateBundle\Entity\Date;

class CelebrationListener
{
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        foreach ($entities as $entity) {

            if(!($entity instanceof Celebration)) {
                continue;
            }

            if($entity->getDate() == NULL) {
                $date = new Date();
                $entity->setDate($date);
            }

            $date = $entity->getDate();

            $startingDate = date_create($entity->getDateLocal()->format('Y-m-d'));
            $startingDate->setTime($entity->getStartingTime()->format('H'), $entity->getStartingTime()->format('i'));

            $endingDate = date_create($entity->getDateLocal()->format('Y-m-d'));
            $endingDate->setTime($entity->getEndingTime()->format('H'), $entity->getEndingTime()->format('i'));

            $date->setStart($startingDate);
            $date->setEnd($endingDate);

            $em->persist($date);
            $md = $em->getClassMetadata('gospelcenter\DateBundle\Entity\Date');
            $uow->computeChangeSet($md, $date);
        }


    }


}

