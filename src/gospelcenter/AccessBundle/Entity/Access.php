<?php

namespace gospelcenter\AccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Access
 *
 * @ORM\Table(name="access")
 * @ORM\Entity(repositoryClass="gospelcenter\AccessBundle\Entity\AccessRepository")
 */
class Access
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255)
     */
    private $service;
    
    /**
     * is granted to
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\AccessBundle\Entity\AccessLevel", mappedBy="access")
     * @Assert\Valid()
     */
    private $accessLevels;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accessLevels = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set service
     *
     * @param string $service
     * @return Access
     */
    public function setService($service)
    {
        $this->service = $service;
    
        return $this;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Add accessLevels
     *
     * @param \gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels
     * @return Access
     */
    public function addAccessLevel(\gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels)
    {
        $this->accessLevels[] = $accessLevels;
    
        return $this;
    }

    /**
     * Remove accessLevels
     *
     * @param \gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels
     */
    public function removeAccessLevel(\gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels)
    {
        $this->accessLevels->removeElement($accessLevels);
    }

    /**
     * Get accessLevels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccessLevels()
    {
        return $this->accessLevels;
    }
}