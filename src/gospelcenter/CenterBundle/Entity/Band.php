<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Band
 *
 * @ORM\Table(name="band")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\BandRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\NotBlank(message="Please enter a title.")
     */
    private $title;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     * @Assert\DateTime()
     */
    private $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     * @Assert\DateTime()
     */
    private $modifiedDate;
    
    
    /**
     * depends on
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Band", inversedBy="bandsOwned")
     * @Assert\Valid()
     */
    private $bandOwner;
    
    
    /**
     * is depended of
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", mappedBy="bandOwner")
     * @Assert\Valid()
     */
    private $bandsOwned;
    
    
    /**
     * is owned by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="bands")
     * @Assert\Valid()
     */
    private $center;
    
    
    /**
     * manages
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Role", mappedBy="bands")
     * @Assert\Valid()
     */
    private $roles;
    
    
    /**
     * is populated by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="bandsPopulated")
     * @ORM\JoinTable(name="bands_members")
     * @Assert\Valid()
     */
    private $members;
    
    
    /**
     * is managed by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="bandsManaged")
     * @ORM\JoinTable(name="bands_managers")
     * @Assert\Valid()
     */
    private $managers;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bandsOwned = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSave()
    {
        $this->modifiedDate = new \Datetime();
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Band
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Band
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    
        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set bandOwner
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandOwner
     * @return Band
     */
    public function setBandOwner(\gospelcenter\CenterBundle\Entity\Band $bandOwner = null)
    {
        $this->bandOwner = $bandOwner;
    
        return $this;
    }

    /**
     * Get bandOwner
     *
     * @return \gospelcenter\CenterBundle\Entity\Band 
     */
    public function getBandOwner()
    {
        return $this->bandOwner;
    }

    /**
     * Add bandsOwned
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsOwned
     * @return Band
     */
    public function addBandsOwned(\gospelcenter\CenterBundle\Entity\Band $bandsOwned)
    {
        $this->bandsOwned[] = $bandsOwned;
    
        return $this;
    }

    /**
     * Remove bandsOwned
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsOwned
     */
    public function removeBandsOwned(\gospelcenter\CenterBundle\Entity\Band $bandsOwned)
    {
        $this->bandsOwned->removeElement($bandsOwned);
    }

    /**
     * Get bandsOwned
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBandsOwned()
    {
        return $this->bandsOwned;
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