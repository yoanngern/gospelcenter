<?php

namespace gospelcenter\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{

    public function findAllByCenter(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->addOrderBy('p.title', 'ASC')
            ->addOrderBy('l.ref', 'ASC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findYouthByCenter(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->where('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('p.ref = :ref')
            ->setParameter('ref', "youth");
            
        $qb->addOrderBy('l.ref', 'ASC')
            ->addOrderBy('p.sort', 'ASC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function getSelectList($center)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->leftJoin('p.center', 'c');
        $qb->join('p.language', 'l');
        
        if($center == null) {
            $qb->andWhere('p.center IS NULL');
        } else {
            $qb->where('c.ref = :center')
                ->setParameter('center', $center->getRef());
        }
            
        $qb->addOrderBy('p.title', 'ASC')
            ->addOrderBy('l.ref', 'ASC');
        
        return $qb;
    }
    
    
    public function findAPage(\gospelcenter\CenterBundle\Entity\Center $center, $pageRef)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->where('p.ref = :page')
            ->setParameter('page', $pageRef);
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', 'fr');
            
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
    public function findAYouthGroupByAlias(\gospelcenter\CenterBundle\Entity\Center $center, $alias)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->where('p.alias = :alias')
            ->setParameter('alias', $alias);
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', 'fr');
            
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
    public function findAYouthGroupByTitle(\gospelcenter\CenterBundle\Entity\Center $center, $title)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->where('p.title = :title')
            ->setParameter('title', $title);
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', 'fr');
            
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
    public function findYouthPages(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->leftJoin('p.slides', 's');
        $qb->join('p.language', 'l');
        
        $qb->where('p.ref = :page')
            ->setParameter('page', 'youth');
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', 'fr');
            
        $qb->addOrderBy('p.sort', 'ASC')
            ->addOrderBy('p.title', 'ASC');
            
        
        return $qb->getQuery()->getResult();
    }
    
    
    public function findAGlobalPage($pageRef)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.language', 'l');
        
        $qb->where('p.ref = :page')
            ->setParameter('page', $pageRef);
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', 'fr');
            
        $qb->andWhere('p.center IS NULL');
            
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
    public function findAllGlobal()
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.language', 'l');
        
        $qb->addOrderBy('p.title', 'ASC')
            ->addOrderBy('l.ref', 'ASC');
        
        $qb->andWhere('p.center IS NULL');
        
        return $qb->getQuery()->getResult();
    }
    
}
