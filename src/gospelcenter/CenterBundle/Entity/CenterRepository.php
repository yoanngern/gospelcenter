<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CenterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CenterRepository extends EntityRepository
{

    public function findAllLocationOfCenter(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->join('c.events', 'e')
            ->addSelect('e');
        
        $qb->join('c.celebrations', 'cel')
            ->addSelect('cel');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('e.startingDate > :now')
            ->setParameter('now', new \Datetime());
            
        $qb->andWhere('cel.startingDate > :now')
            ->setParameter('now', new \Datetime());
            
        $qb->addOrderBy('e.startingDate', 'ASC');
        $qb->addOrderBy('cel.startingDate', 'ASC');
            
        return $qb->getQuery()->getSingleResult();
        
    }
    
    public function findNextDates(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->join('c.location', 'l')
            ->addSelect('l');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        return $qb->getQuery()->getResult();
        
    }
    
    public function findAllLocationOfEvents(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->join('c.events', 'e')
            ->addSelect('e');
            
        $qb->join('e.location', 'l')
            ->addSelect('l');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        return $qb->getQuery()->getOneOrNullResult();
        
    }
    
    public function findAllLocationOfCelebrations(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->join('c.celebrations', 'cel')
            ->addSelect('cel');
            
        $qb->join('cel.location', 'l')
            ->addSelect('l');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        return $qb->getQuery()->getOneOrNullResult();
        
    }
    
    public function findAllWithMedia()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                '
                SELECT c, cel, v, a
                FROM gospelcenterCenterBundle:Center c
                JOIN c.celebrations cel
                LEFT JOIN cel.video v
                LEFT JOIN cel.audio a
                WHERE v.id > 0 OR a.id > 0
                ORDER BY c.name ASC'
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    
}
