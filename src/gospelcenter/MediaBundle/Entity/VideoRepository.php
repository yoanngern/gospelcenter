<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends EntityRepository
{


    public function findVideosSameSpeaker(Video $video, $speakers)
    {

        $dql = '
                SELECT v
                FROM gospelcenterMediaBundle:Video v
                JOIN v.celebration cel
                JOIN cel.speakers s
                JOIN s.person p
                JOIN cel.date d
                WHERE v.id != :video_id';

        foreach($speakers as $speaker) {
            $dql .= ' AND p.id = ' . $speaker;
        }
        $dql .= 'ORDER BY d.start DESC';

        $query = $this->getEntityManager()
            ->createQuery($dql)->setParameters(
                array(
                    'video_id' => $video->getId()
                )
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
