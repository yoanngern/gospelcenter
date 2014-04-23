<?php

namespace gospelcenter\CelebrationBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CelebrationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CelebrationRepository extends EntityRepository
{
    public function findAllByCenter(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->addSelect('s');
        $qb->addSelect('p');
        $qb->addSelect('v');
        $qb->addSelect('a');
        $qb->addSelect('m');
        $qb->addSelect('vi');
        
        $qb->join('cel.center', 'c');
        $qb->leftJoin('cel.speakers', 's');
        $qb->leftJoin('s.person', 'p');
        $qb->leftJoin('p.member', 'm');
        $qb->leftJoin('p.visitor', 'vi');
        $qb->leftJoin('cel.video', 'v');
        $qb->leftJoin('cel.audio', 'a');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
        
        $qb->addOrderBy('cel.startingDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findNext(\gospelcenter\CenterBundle\Entity\Center $center, $nb)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.center', 'c');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('cel.startingDate > :now')
            ->setParameter('now', new \Datetime());
        
        $qb->orderBy('cel.startingDate', 'ASC');
        
        if($nb > 0)
        {
            $qb->setMaxResults($nb);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function findLast(\gospelcenter\CenterBundle\Entity\Center $center, $nb)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.center', 'c');
        $qb->join('cel.video', 'v');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('cel.startingDate < :now')
            ->setParameter('now', new \Datetime());
        
        $qb->orderBy('cel.startingDate', 'DESC');
        
        if($nb > 0)
        {
            $qb->setMaxResults($nb);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function findLastVideo($nb)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.video', 'v');
            
        $qb->andWhere('cel.bestOf = 0');
        $qb->andWhere('cel.startingDate < :now')
            ->setParameter('now', new \Datetime());
        
        $qb->orderBy('cel.startingDate', 'DESC');
        
        if($nb > 0)
        {
            $qb->setMaxResults($nb);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function findStarVideo($nb)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.video', 'v');
        
        $qb->andWhere('cel.bestOf = 1');
        $qb->andWhere('cel.startingDate < :now')
            ->setParameter('now', new \Datetime());
        
        $qb->orderBy('cel.startingDate', 'DESC');
        
        if($nb > 0)
        {
            $qb->setMaxResults($nb);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function findAllBySpeakerWithMedia(\gospelcenter\CelebrationBundle\Entity\Speaker $speaker)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.center', 'c');
        $qb->join('cel.speakers', 's');
        $qb->join('s.person', 'p');
        $qb->leftJoin('cel.video', 'v');
        $qb->leftJoin('cel.audio', 'a');
            
        $qb->where('p.id = :speaker')
            ->setParameter('speaker', $speaker->getPerson()->getId());
        
        $qb->addOrderBy('cel.startingDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findAllWithVideo()
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.video', 'v');
        
        $qb->addOrderBy('cel.startingDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    
    public function findAllWithAudio()
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.audio', 'a');
        
        $qb->addOrderBy('cel.startingDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findAllByCenterWithMedia(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('cel');
        
        $qb->join('cel.center', 'c');
        $qb->join('cel.speakers', 's');
        $qb->join('s.person', 'p');
        $qb->leftJoin('cel.video', 'v');
        $qb->leftJoin('cel.audio', 'a');
            
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
        
        $qb->addOrderBy('cel.startingDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
}
