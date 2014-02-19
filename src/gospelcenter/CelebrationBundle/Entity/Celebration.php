<?php

namespace gospelcenter\CelebrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Celebration
 *
 * @ORM\Table(name="celebration")
 * @ORM\Entity(repositoryClass="gospelcenter\CelebrationBundle\Entity\CelebrationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Celebration
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingDate", type="datetime", nullable=true)
     */
    private $startingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endingDate", type="datetime")
     */
    private $endingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bestOf", type="boolean")
     */
    private $bestOf;

    /**
     * @var boolean
     *
     * @ORM\Column(name="kidsProgram", type="boolean")
     */
    private $kidsProgram;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     */
    private $modifiedDate;
    
    private $existingSpeakers;
    
    private $newSpeakers;
    
    private $date;
    
    private $startingTime;
    
    private $endingTime;
    
    
    /**
     * is organised by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="celebrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $center;
    
    
    /**
     * is imaged by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="celebrations", cascade={"persist", "remove"})
     */
    private $image;
    
    
    /**
     * is situated by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="celebrations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    
    
    /**
     * is diffused by
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\MediaBundle\Entity\Video", mappedBy="celebration")
     */
    private $video;
    
    
    /**
     * is spreader by
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\MediaBundle\Entity\Audio", mappedBy="celebration")
     */
    private $audio;
    
    
    /**
     * is tagged by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Tag", inversedBy="celebrations")
     */
    private $tags;
    
    
    /**
     * is preached by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Speaker", inversedBy="celebrations", cascade={"persist"})
     */
    private $speakers;
    
    
    /**
     * is composed by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Role", inversedBy="celebrations")
     */
    private $roles;
    
    
    /*
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $this->status = true;
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->speakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->existingSpeakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->newSpeakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modifiedDate = new \Datetime();
        $this->center = $center;
    }
    
    public function setExistingSpeakers($existingSpeakers)
    {
        $this->existingSpeakers = $existingSpeakers;
        
        return $this;
    }
    
    
    public function getExistingSpeakers()
    {
        return $this->existingSpeakers;
    }
    
    public function setNewSpeakers($newSpeakers)
    {
        $this->newSpeakers = $newSpeakers;
        
        return $this;
    }
    
    
    public function getNewSpeakers()
    {
        return $this->newSpeakers;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
        
        return $this;
    }
    
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setStartingTime($startingTime)
    {
        $this->startingTime = $startingTime;
        
        return $this;
    }
    
    
    public function getStartingTime()
    {
        return $this->startingTime;
    }
    
    public function setEndingTime($endingTime)
    {
        $this->endingTime = $endingTime;
        
        return $this;
    }
    
    
    public function getEndingTime()
    {
        return $this->endingTime;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSave()
    {
        
        $startingDate = date_create($this->date->format('Y-m-d'));
        $startingDate->setTime($this->startingTime->format('H'), $this->startingTime->format('i'));
        $this->startingDate = $startingDate;
        
        $endingDate = date_create($this->date->format('Y-m-d'));
        $endingDate->setTime($this->endingTime->format('H'), $this->endingTime->format('i'));
        $this->endingDate = $endingDate;
        
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
     * @return Celebration
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
     * Set startingDate
     *
     * @param \DateTime $startingDate
     * @return Celebration
     */
    public function setStartingDate($startingDate)
    {
        $this->startingDate = $startingDate;
    
        return $this;
    }

    /**
     * Get startingDate
     *
     * @return \DateTime 
     */
    public function getStartingDate()
    {
        return $this->startingDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate
     * @return Celebration
     */
    public function setEndingDate($endingDate)
    {
        $this->endingDate = $endingDate;
    
        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime 
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Celebration
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Celebration
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set bestOf
     *
     * @param boolean $bestOf
     * @return Celebration
     */
    public function setBestOf($bestOf)
    {
        $this->bestOf = $bestOf;
    
        return $this;
    }

    /**
     * Get bestOf
     *
     * @return boolean 
     */
    public function getBestOf()
    {
        return $this->bestOf;
    }

    /**
     * Set kidsProgram
     *
     * @param boolean $kidsProgram
     * @return Celebration
     */
    public function setKidsProgram($kidsProgram)
    {
        $this->kidsProgram = $kidsProgram;
    
        return $this;
    }

    /**
     * Get kidsProgram
     *
     * @return boolean 
     */
    public function getKidsProgram()
    {
        return $this->kidsProgram;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Celebration
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
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Celebration
     */
    public function setCenter(\gospelcenter\CenterBundle\Entity\Center $center)
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
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Celebration
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image)
    {
        $this->image = $image;
        
        if($image != null) {
            $title = date_format($this->startingDate, 'd m Y');
            $this->image->setTitle($title);
            $this->image->setType('Celebration');
        }
    
        return $this;
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
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Celebration
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location)
    {
        $this->location = $location;
    
        return $this;
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
     * Set video
     *
     * @param \gospelcenter\MediaBundle\Entity\Video $video
     * @return Celebration
     */
    public function setVideo(\gospelcenter\MediaBundle\Entity\Video $video = null)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return \gospelcenter\MediaBundle\Entity\Video 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set audio
     *
     * @param \gospelcenter\MediaBundle\Entity\Audio $audio
     * @return Celebration
     */
    public function setAudio(\gospelcenter\MediaBundle\Entity\Audio $audio = null)
    {
        $this->audio = $audio;
    
        return $this;
    }

    /**
     * Get audio
     *
     * @return \gospelcenter\MediaBundle\Entity\Audio 
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * Add tags
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Tag $tags
     * @return Celebration
     */
    public function addTag(\gospelcenter\CelebrationBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Tag $tags
     */
    public function removeTag(\gospelcenter\CelebrationBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add speakers
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Speaker $speakers
     * @return Celebration
     */
    public function addSpeaker(\gospelcenter\CelebrationBundle\Entity\Speaker $speakers)
    {
        $this->speakers[] = $speakers;
        $speakers->addCelebration($this);
    
        return $this;
    }

    /**
     * Remove speakers
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Speaker $speakers
     */
    public function removeSpeaker(\gospelcenter\CelebrationBundle\Entity\Speaker $speakers)
    {
        $this->speakers->removeElement($speakers);
        $speakers->removeCelebration($this);
    }

    /**
     * Get speakers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * Add roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     * @return Celebration
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
}