<?php

namespace gospelcenter\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="gospelcenter\EventBundle\Entity\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingDate", type="datetime")
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
     * @ORM\Column(name="introText", type="text")
     */
    private $introText;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    
    /**
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     */
    private $modifiedDate;
    
    /**
     * takes place at
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="events")
     */
    private $location;
    
    /**
     * is illustrated by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="eventsPicture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $picture;
    
    
    /**
     * is covered by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="eventsCover", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cover;
    
    
    /**
     * is presented by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Center", mappedBy="events")
     */
     private $centers;
     
    
    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->status = true;
        $this->modifiedDate = new \Datetime();
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
        
        if($center != null){
            $this->centers[] = $center;
        }
    }
    
    /**
     * Set picture
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $picture
     * @return Event
     */
    public function setPicture(\gospelcenter\ImageBundle\Entity\Image $picture = null)
    {
        $this->picture = $picture;
        
        if($picture != null) {
            $title = $this->title . " - Picture";
            $this->picture->setTitle($title);
            $this->picture->setType('Event');
        }
    
        return $this;
    }
    
    /**
     * Set cover
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $cover
     * @return Event
     */
    public function setCover(\gospelcenter\ImageBundle\Entity\Image $cover = null)
    {
        $this->cover = $cover;
        
        if($cover != null) {
            $title = $this->title . " - Cover";
            $this->cover->setTitle($title);
            $this->cover->setType('Event');
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
     * Set title
     *
     * @param string $title
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * Set introText
     *
     * @param string $introText
     * @return Event
     */
    public function setIntroText($introText)
    {
        $this->introText = $introText;
    
        return $this;
    }

    /**
     * Get introText
     *
     * @return string 
     */
    public function getIntroText()
    {
        return $this->introText;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Event
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Event
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
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Event
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
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Event
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location = null)
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
     * Get picture
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Get cover
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Add centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     * @return Event
     */
    public function addCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers[] = $centers;
    
        return $this;
    }

    /**
     * Remove centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     */
    public function removeCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers->removeElement($centers);
    }

    /**
     * Get centers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCenters()
    {
        return $this->centers;
    }
}