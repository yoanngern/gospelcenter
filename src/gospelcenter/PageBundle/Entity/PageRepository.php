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
    
    
    public function findAPage(\gospelcenter\CenterBundle\Entity\Center $center, $pageRef, $language)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');

        
        $qb->where('p.ref = :page')
            ->setParameter('page', $pageRef);
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', $language);
            
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    
    public function findAYouthGroupByAlias(\gospelcenter\CenterBundle\Entity\Center $center, $language)
    {
        $qb = $this->createQueryBuilder('p');
        
        $qb->join('p.center', 'c');
        $qb->join('p.language', 'l');
        
        $qb->andWhere('c.ref = :center')
            ->setParameter('center', $center->getRef());
            
        $qb->andWhere('l.ref = :language')
            ->setParameter('language', $language);
            
        
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
    
    
    public function findYouthPages(\gospelcenter\CenterBundle\Entity\Center $center, $page, $language)
    {

        $query = $this->getEntityManager()
            ->createQuery(
                "
                SELECT p, s, l, c
                FROM gospelcenterPageBundle:Page p
                JOIN p.center c
                LEFT JOIN p.slides s
                JOIN p.language l
                WHERE c.ref = :center AND l.ref = :language AND (p.alias = :page OR ('youth' = :page AND p.ref = :page ))
                ORDER BY p.sort ASC, p.title ASC"
            )->setParameters(
                array(
                    'center' => $center->getRef(),
                    'page' => $page,
                    'language' => $language,
                )
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
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
