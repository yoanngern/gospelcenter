<?php

namespace gospelcenter\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use gospelcenter\CelebrationBundle\Entity\Speaker;

use FOS\UserBundle\Entity\User;

/**
 * Person
 *
 * @ORM\Entity
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="gospelcenter\PeopleBundle\Entity\PersonRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Person
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
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a firstname.")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a lastname.")
     */
    private $lastname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfBirth", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="privatePhone", type="string", length=255, nullable=true)
     */
    private $privatePhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mobilePhone", type="string", length=255, nullable=true)
     */
    private $mobilePhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="abroad", type="boolean", nullable=true)
     */
    private $abroad;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="hasChildren", type="boolean", nullable=true)
     */
    private $hasChildren;
    
    /**
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=255, nullable=true)
     */
    private $function;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isGlobal", type="boolean", nullable=true)
     */
    private $isGlobal;
    
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
    
    
    private $isSpeaker;
    private $isMember;
    private $isVisitor;
    
    
    /**
     * organizes
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Base", inversedBy="organizers")
     * @Assert\Valid()
     */
    private $baseOrganized;
    
    
    /**
     * participates
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Base", inversedBy="participants")
     * @Assert\Valid()
     */
    private $baseParticipated;
    
    
    /**
     * manages
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", mappedBy="managers")
     * @Assert\Valid()
     */
    private $bandsManaged;
    
    
    /**
     * is member of
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", mappedBy="members")
     * @Assert\Valid()
     */
    private $bandsPopulated;
    
    
    /**
     * lives in
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="persons", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $location;
    
    
    /**
     * plays
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Role", mappedBy="persons")
     * @Assert\Valid()
     */
    private $roles;
    
    
    /**
     * is parent of a Speaker
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Speaker", mappedBy="person", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $speaker;
    
    
    /**
     * is parent of a Member
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CenterBundle\Entity\Member", mappedBy="person", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $member;
    
    
    /**
     * is created by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="persons", cascade={"detach"})
     * @Assert\Valid()
     */
    private $center;
    
    
    /**
     * is parent of a Visitor
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CenterBundle\Entity\Visitor", mappedBy="person", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $visitor;
    
    
    /**
     * is shown by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="persons", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;
    
    
    /**
     * speaks
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\LanguageBundle\Entity\Language", inversedBy="persons")
     */
    private $languages;
    
    
    /**
     * can be a
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\UserBundle\Entity\User", inversedBy="person", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $user;
    
    
    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
        $this->status = 1;
        $this->bandsManaged = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bandsPopulated = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->center = $center;
        
    }
    
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSave()
    {
        $this->modifiedDate = new \Datetime();
    }
    
    
    /**
     * Display a Person
     * @return String 
     */
    public function __toString()
    {   
        $id = $this->id;
        return (string)$id;
    }
    
    public function setIsSpeaker($isSpeaker)
    {
        $this->isSpeaker = $isSpeaker;
        
    }
    
    public function getIsSpeaker()
    {
        return $this->isSpeaker;
    }
    
    public function setIsMember($isMember)
    {
        $this->isMember = $isMember;
        
    }
    
    public function getIsMember()
    {
        return $this->isMember;
    }
    
    public function setIsVisitor($isVisitor)
    {
        $this->isVisitor = $isVisitor;
        
    }
    
    public function getIsVisitor()
    {
        return $this->isVisitor;
    }
    
    /**
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Person
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        
        if($image != null) {
            $title = $this->firstname ." ". $this->lastname;
            $this->image->setTitle($title);
            $this->image->setType('Person');
        }
    
        return $this;
    }
    
    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Person
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        if($location != null) {
            $name = $this->firstname ." ". $this->lastname;
            $this->location->setName($name);
        }
        
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
     * Set firstname
     *
     * @param string $firstname
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Person
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return Person
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    
        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set privatePhone
     *
     * @param string $privatePhone
     * @return Person
     */
    public function setPrivatePhone($privatePhone)
    {
        $this->privatePhone = $privatePhone;
    
        return $this;
    }

    /**
     * Get privatePhone
     *
     * @return string 
     */
    public function getPrivatePhone()
    {
        return $this->privatePhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     * @return Person
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    
        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Person
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set abroad
     *
     * @param boolean $abroad
     * @return Person
     */
    public function setAbroad($abroad)
    {
        $this->abroad = $abroad;
    
        return $this;
    }

    /**
     * Get abroad
     *
     * @return boolean 
     */
    public function getAbroad()
    {
        return $this->abroad;
    }

    /**
     * Set hasChildren
     *
     * @param boolean $hasChildren
     * @return Person
     */
    public function setHasChildren($hasChildren)
    {
        $this->hasChildren = $hasChildren;
    
        return $this;
    }

    /**
     * Get hasChildren
     *
     * @return boolean 
     */
    public function getHasChildren()
    {
        return $this->hasChildren;
    }

    /**
     * Set function
     *
     * @param string $function
     * @return Person
     */
    public function setFunction($function)
    {
        $this->function = $function;
    
        return $this;
    }

    /**
     * Get function
     *
     * @return string 
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Person
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isGlobal
     *
     * @param boolean $isGlobal
     * @return Person
     */
    public function setIsGlobal($isGlobal)
    {
        $this->isGlobal = $isGlobal;
    
        return $this;
    }

    /**
     * Get isGlobal
     *
     * @return boolean 
     */
    public function getIsGlobal()
    {
        return $this->isGlobal;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Person
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
     * @return Person
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
     * Set baseOrganized
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $baseOrganized
     * @return Person
     */
    public function setBaseOrganized(\gospelcenter\CenterBundle\Entity\Base $baseOrganized = null)
    {
        $this->baseOrganized = $baseOrganized;
    
        return $this;
    }

    /**
     * Get baseOrganized
     *
     * @return \gospelcenter\CenterBundle\Entity\Base 
     */
    public function getBaseOrganized()
    {
        return $this->baseOrganized;
    }

    /**
     * Set baseParticipated
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $baseParticipated
     * @return Person
     */
    public function setBaseParticipated(\gospelcenter\CenterBundle\Entity\Base $baseParticipated = null)
    {
        $this->baseParticipated = $baseParticipated;
    
        return $this;
    }

    /**
     * Get baseParticipated
     *
     * @return \gospelcenter\CenterBundle\Entity\Base 
     */
    public function getBaseParticipated()
    {
        return $this->baseParticipated;
    }

    /**
     * Add bandsManaged
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsManaged
     * @return Person
     */
    public function addBandsManaged(\gospelcenter\CenterBundle\Entity\Band $bandsManaged)
    {
        $this->bandsManaged[] = $bandsManaged;
    
        return $this;
    }

    /**
     * Remove bandsManaged
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsManaged
     */
    public function removeBandsManaged(\gospelcenter\CenterBundle\Entity\Band $bandsManaged)
    {
        $this->bandsManaged->removeElement($bandsManaged);
    }

    /**
     * Get bandsManaged
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBandsManaged()
    {
        return $this->bandsManaged;
    }

    /**
     * Add bandsPopulated
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsPopulated
     * @return Person
     */
    public function addBandsPopulated(\gospelcenter\CenterBundle\Entity\Band $bandsPopulated)
    {
        $this->bandsPopulated[] = $bandsPopulated;
    
        return $this;
    }

    /**
     * Remove bandsPopulated
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bandsPopulated
     */
    public function removeBandsPopulated(\gospelcenter\CenterBundle\Entity\Band $bandsPopulated)
    {
        $this->bandsPopulated->removeElement($bandsPopulated);
    }

    /**
     * Get bandsPopulated
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBandsPopulated()
    {
        return $this->bandsPopulated;
    }

    /**
     * Get location
     *
     * @return \gospelcenter\LocationBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     * @return Person
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
     * Set speaker
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Speaker $speaker
     * @return Person
     */
    public function setSpeaker(\gospelcenter\CelebrationBundle\Entity\Speaker $speaker = null)
    {
        $this->speaker = $speaker;
    
        return $this;
    }

    /**
     * Get speaker
     *
     * @return \gospelcenter\CelebrationBundle\Entity\Speaker 
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * Set member
     *
     * @param \gospelcenter\CenterBundle\Entity\Member $member
     * @return Person
     */
    public function setMember(\gospelcenter\CenterBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \gospelcenter\CenterBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Person
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
     * Set visitor
     *
     * @param \gospelcenter\CenterBundle\Entity\Visitor $visitor
     * @return Person
     */
    public function setVisitor(\gospelcenter\CenterBundle\Entity\Visitor $visitor = null)
    {
        $this->visitor = $visitor;
    
        return $this;
    }

    /**
     * Get visitor
     *
     * @return \gospelcenter\CenterBundle\Entity\Visitor 
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Get image
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add languages
     *
     * @param \gospelcenter\LanguageBundle\Entity\Language $languages
     * @return Person
     */
    public function addLanguage(\gospelcenter\LanguageBundle\Entity\Language $languages)
    {
        $this->languages[] = $languages;
    
        return $this;
    }

    /**
     * Remove languages
     *
     * @param \gospelcenter\LanguageBundle\Entity\Language $languages
     */
    public function removeLanguage(\gospelcenter\LanguageBundle\Entity\Language $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set user
     *
     * @param \gospelcenter\UserBundle\Entity\User $user
     * @return Person
     */
    public function setUser(\gospelcenter\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \gospelcenter\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}