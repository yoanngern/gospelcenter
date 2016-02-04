<?php

namespace gospelcenter\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use gospelcenter\DateBundle\Entity\Date;
use gospelcenter\DateBundle\gospelcenterDateBundle;
use gospelcenter\MediaBundle\Entity\Video;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Please enter a title.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="introText", type="text")
     * @Assert\NotBlank()
     */
    private $introText;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     */
    private $category;

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
     * is presented by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Center", mappedBy="events")
     * @Assert\Valid()
     */
    private $centers;


    /**
     * takes place at
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="events", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $location;


    /**
     * is at
     *
     * @ORM\OneToMany(targetEntity="gospelcenter\DateBundle\Entity\Date", mappedBy="event", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $dates;


    /**
     * uses
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\MediaBundle\Entity\Video", inversedBy="events", cascade={"persist", "remove"})
     */
    private $video;


    /**
     * is supplemented by
     *
     * @ORM\OneToMany(targetEntity="gospelcenter\ArticleBundle\Entity\Link", mappedBy="event", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $links;


    /**
     * is covered by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="eventsCover", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $cover;


    /**
     * is illustrated by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="eventsPicture", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $picture;

    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->status = true;
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();

        if ($center != null) {
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

        if ($picture != null) {
            $title = $this->title . " - Picture";
            $this->picture->setTitle($title);
            $this->picture->setType('Event');

            $picture->addEventsPicture($this);
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

        if ($cover != null) {
            $title = $this->title . " - Cover";
            $this->cover->setTitle($title);
            $this->cover->setType('Event');

            $cover->addEventsCover($this);
        }

        return $this;
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
        $centers->addEvent($this);

        return $this;
    }

    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Event
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location)
    {

        $this->location = $location;

        return $this;
    }


    /**
     * Add dates
     *
     * @param \gospelcenter\DateBundle\Entity\Date $dates
     * @return Event
     */
    public function addDate(\gospelcenter\DateBundle\Entity\Date $dates)
    {
        $this->dates[] = $dates;

        $dates->setEvent($this);

        return $this;
    }


    /**
     * Set dates
     *
     * @param \gospelcenter\DateBundle\Entity\Date $dates
     * @return Event
     */
    public function setDates(\gospelcenter\DateBundle\Entity\Date $dates)
    {
        foreach($dates as $date) {
            $date->setEvent($this);
        }

        $this->dates = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \gospelcenter\DateBundle\Entity\Date $dates
     */
    public function removeDate(\gospelcenter\DateBundle\Entity\Date $dates)
    {
        $this->dates->removeElement($dates);

        $dates->setEvent();
    }


    /**
     * Add links
     *
     * @param \gospelcenter\ArticleBundle\Entity\Link $links
     * @return Event
     */
    public function addLink(\gospelcenter\ArticleBundle\Entity\Link $links)
    {

        $this->links[] = $links;

        $links->setEvent($this);

        return $this;
    }


    /**
     * Set links
     *
     * @param \gospelcenter\ArticleBundle\Entity\Link $links
     * @return Event
     */
    public function setLinks(\gospelcenter\ArticleBundle\Entity\Link $links)
    {
        foreach($links as $link) {
            $link->setEvent($this);
        }

        $this->links = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \gospelcenter\ArticleBundle\Entity\Link $links
     */
    public function removeLink(\gospelcenter\ArticleBundle\Entity\Link $links)
    {
        $this->links->removeElement($links);

        $links->setEvent();
    }


    /**
     * Set video
     *
     * @param \gospelcenter\MediaBundle\Entity\Video $video
     * @return Event
     */
    public function setVideo(\gospelcenter\MediaBundle\Entity\Video $video = null)
    {
        $this->video = $video;
        $video->addEvent($this);

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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Event
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
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
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
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
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
     * Get picture
     *
     * @return \gospelcenter\ImageBundle\Entity\Image
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Event
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }
}