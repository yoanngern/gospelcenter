<?php

namespace gospelcenter\ImageBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use gospelcenter\ImageBundle\Entity\Image;

class CacheImageListener
{
    protected $cacheManager;

    public function __construct($cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Image) {

            $this->cacheManager->remove($entity->getUploadDir());
        }
    }
}