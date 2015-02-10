<?php

namespace gospelcenter\ArticleBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdRepository extends EntityRepository
{


    public function findAllForHome(\gospelcenter\CenterBundle\Entity\Center $center)
    {

        $query = $this->getEntityManager()
            ->createQuery(
                '
                SELECT a, i, c, c2
                FROM gospelcenterArticleBundle:Ad a
                LEFT JOIN a.center c
                LEFT JOIN a.image i
                LEFT JOIN i.center c2
                WHERE c.ref = :center AND a.status = 1
                '
            )->setParameters(
                array(
                    'center' => $center->getRef()
                )
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }

    }

    public function findAllByCenter(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->join('a.center', 'c');

        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());

        return $qb->getQuery()->getResult();
    }
}
