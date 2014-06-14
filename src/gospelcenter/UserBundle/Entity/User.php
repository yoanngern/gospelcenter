<?php

namespace gospelcenter\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use gospelcenter\PeopleBundle\Entity\Person;

/**
 * User
 * 
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * is
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="user")
     * @Assert\Valid()
     */
    private $person;
    
    /**
     * @ORM\ManyToMany(targetEntity="gospelcenter\UserBundle\Entity\Unit", mappedBy="users")
     * @Assert\Valid()
     */
    protected $units;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enabled = 1;
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
     * Set person
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $person
     * @return User
     */
    public function setPerson(\gospelcenter\PeopleBundle\Entity\Person $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return \gospelcenter\PeopleBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Add units
     *
     * @param \gospelcenter\UserBundle\Entity\Unit $units
     * @return User
     */
    public function addUnit(\gospelcenter\UserBundle\Entity\Unit $units)
    {
        $this->units[] = $units;
    
        return $this;
    }

    /**
     * Remove units
     *
     * @param \gospelcenter\UserBundle\Entity\Unit $units
     */
    public function removeUnit(\gospelcenter\UserBundle\Entity\Unit $units)
    {
        $this->units->removeElement($units);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }
}