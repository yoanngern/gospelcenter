<?php

namespace gospelcenter\UserBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
 * @ORM\HasLifecycleCallbacks
 */
class Unit extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;
     
     /**
     * @ORM\ManyToMany(targetEntity="gospelcenter\UserBundle\Entity\User", inversedBy="units")
     * @Assert\Valid()
     */
     protected $users;
     
     private $localRoles;
     
    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->localRoles = array();
        $this->roles = array();
    }
    
    public function setLocalRoles($localRoles)
    {
        $this->localRoles = $localRoles;
        
        return $this;
    }
    
    
    public function getLocalRoles()
    {
        return $this->localRoles;
    }

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
     * Add users
     *
     * @param \gospelcenter\UserBundle\Entity\User $users
     * @return Unit
     */
    public function addUser(\gospelcenter\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \gospelcenter\UserBundle\Entity\User $users
     */
    public function removeUser(\gospelcenter\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}