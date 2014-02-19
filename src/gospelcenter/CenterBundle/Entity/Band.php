<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Band
 *
 * @ORM\Table(name="band")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\BandRepository")
 */
class Band
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
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;
    
    
    /**
     * is owned by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="bands")
     */
    private $center;
    
    
    /**
     * manages
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Role", mappedBy="bands")
     */
    private $roles;
    
    
    /**
     * is populated by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="bandsPopulated")
     * @ORM\JoinTable(name="bands_members")
     */
    private $members;
    
    
    /**
     * is managed by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="bandsManaged")
     * @ORM\JoinTable(name="bands_managers")
     */
    private $managers;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Band
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Band
     */
    public function setCenter(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->center = $center;
    
        return $this;
    }

    /**
     * Get center
     *
     * @return \gospelcenter\CenterBundle\Entity\Center 
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * Add roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     * @return Band
     */
    public function addRole(\gospelcenter\PeopleBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     */
    public function removeRole(\gospelcenter\PeopleBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add members
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $members
     * @return Band
     */
    public function addMember(\gospelcenter\PeopleBundle\Entity\Person $members)
    {
        $this->members[] = $members;
    
        return $this;
    }

    /**
     * Remove members
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $members
     */
    public function removeMember(\gospelcenter\PeopleBundle\Entity\Person $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add managers
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $managers
     * @return Band
     */
    public function addManager(\gospelcenter\PeopleBundle\Entity\Person $managers)
    {
        $this->managers[] = $managers;
    
        return $this;
    }

    /**
     * Remove managers
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $managers
     */
    public function removeManager(\gospelcenter\PeopleBundle\Entity\Person $managers)
    {
        $this->managers->removeElement($managers);
    }

    /**
     * Get managers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagers()
    {
        return $this->managers;
    }
}