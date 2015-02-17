<?php

namespace gospelcenter\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{

    public function findAllForHome(\gospelcenter\CenterBundle\Entity\Center $center)
    {

        $query = $this->getEntityManager()
            ->createQuery(
                '
                SELECT d, e, c, pic, cov, c2, c3
                FROM gospelcenterDateBundle:Date d
                JOIN d.event e
                LEFT JOIN e.centers c
                LEFT JOIN e.picture pic
                LEFT JOIN e.cover cov
                LEFT JOIN pic.center c2
                LEFT JOIN cov.center c3
                WHERE c.ref = :center AND e.status = 1 AND d.end >= :now
                GROUP BY e
                ORDER BY d.start ASC
                '
            )->setParameters(
                array(
                    'center' => $center->getRef(),
                    'now' => new \Datetime()
                )
            )->setMaxResults(3);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }

    }

    public function findUpcoming(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->join('e.centers', 'c')
            ->addSelect('c');
        $qb->leftJoin('e.picture', 'p')
            ->addSelect('p');

        $qb->leftJoin('e.dates', 'd')
            ->addSelect('d');

        $qb->where('e.status = :status')
            ->setParameter('status', '1');

        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());

        $qb = $this->nextEvents($qb);

        $qb->orderBy('d.start', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findAllByCenter(\gospelcenter\CenterBundle\Entity\Center $center, $nb, $start)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->join('e.centers', 'c')
            ->addSelect('c');

        $qb->leftJoin('e.location', 'l')
            ->addSelect('l');

        $qb->leftJoin('e.picture', 'pic')
            ->addSelect('pic');

        $qb->leftJoin('e.cover', 'cov')
            ->addSelect('cov');

        $qb->leftJoin('e.dates', 'd')
            ->addSelect('d');

        $qb->where('e.status = :status')
            ->setParameter('status', '1');

        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());

        $qb->orderBy('d.start', 'DESC');

        if ($nb > 0) {
            $qb->setMaxResults($nb);
        }

        $qb->setFirstResult($start);

        return $qb->getQuery()->getResult();

    }

    public function findNextByCenterWithHidden(\gospelcenter\CenterBundle\Entity\Center $center)
    {

        $query = $this->getEntityManager()
            ->createQuery(
                '
                SELECT e, d, l
                FROM gospelcenterEventBundle:Event e
                LEFT JOIN e.location l
                LEFT JOIN e.picture pic
                LEFT JOIN e.cover cov
                JOIN e.centers c
                JOIN e.dates d
                WHERE c.ref = :center AND (d.end >= :now OR d IS NULL)
                ORDER BY d.start ASC'
            )->setParameters(
                array(
                    'center' => $center->getRef(),
                    'now' => new \Datetime(),
                )
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }

    }

    public function findPastByCenterWithHidden(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->addSelect('c1')
            ->addSelect('l')
            ->addSelect('pic')
            ->addSelect('c2')
            ->addSelect('cov')
            ->addSelect('c3')
            ->addSelect('d');

        $qb->join('e.centers', 'c1');

        $qb->leftJoin('e.location', 'l');

        $qb->leftJoin('e.picture', 'pic');
        $qb->leftJoin('pic.center', 'c2');

        $qb->leftJoin('e.cover', 'cov');
        $qb->leftJoin('cov.center', 'c3');

        $qb->leftJoin('e.dates', 'd');

        $qb->where('c1.ref = :center')
            ->setParameter('center', $center->getRef());

        $qb->andWhere('d.end < :now')
            ->setParameter('now', new \Datetime());

        $qb->orderBy('d.start', 'ASC');

        return $qb->getQuery()->getResult();

    }

    public function findNext(\gospelcenter\CenterBundle\Entity\Center $center, $nb)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->join('e.centers', 'c');

        $qb->leftJoin('e.dates', 'd')
            ->addSelect('d');

        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());

        $qb->andWhere('d.end >= :now')
            ->setParameter('now', new \Datetime());

        $qb->andWhere('e.status = 1');

        $qb->orderBy('d.start', 'ASC');

        if ($nb > 0) {
            $qb->setMaxResults($nb);
        }

        return $qb->getQuery()->getResult();
    }

    public function findWithAll(
        \gospelcenter\EventBundle\Entity\Event $event,
        \gospelcenter\CenterBundle\Entity\Center $center
    ) {
        $qb = $this->createQueryBuilder('e');

        $qb->join('e.centers', 'c')
            ->addSelect('c');

        $qb->leftJoin('e.location', 'l')
            ->addSelect('l');

        $qb->leftJoin('e.picture', 'pic')
            ->addSelect('pic');

        $qb->leftJoin('e.cover', 'cov')
            ->addSelect('cov');

        $qb->leftJoin('e.dates', 'd')
            ->addSelect('d');

        $qb->where('e.id = :id')
            ->setParameter('id', $event->getId());

        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());

        return $qb->getQuery()->getSingleResult();
    }

    public function nextEvents(\Doctrine\ORM\QueryBuilder $qb)
    {

        $qb->andWhere('d.end > :now')
            ->setParameter('now', new \Datetime());

        return $qb;
    }

}
