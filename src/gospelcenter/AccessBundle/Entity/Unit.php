<?php

namespace gospelcenter\AccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use gospelcenter\UserBundle\Entity\User;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="gospelcenter\AccessBundle\Entity\UnitRepository")
 */
class Unit
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * groups
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\UserBundle\Entity\User", mappedBy="units")
     * @Assert\Valid()
     */
    private $users;
    
    /**
     * is given
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\AccessBundle\Entity\AccessLevel", mappedBy="unit", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $accessLevels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accessLevels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add accessLevels
     *
     * @param \gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels
     * @return Unit
     */
    public function addAccessLevel(\gospelcenter\AccessBundle\Entity\AccessLevel $accessLevels)
    {
        $this->accessLevels[] = $accessLevels;
        $accessLevels->setUnit($this);

        return $this;
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
     * Set name
     *
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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