<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Center
 *
 * @ORM\Table(name="center")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\CenterRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Center
{

    /**
     * @var string
     * 
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a name.")
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean")
     */
    private $online;
    
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
     * organizes
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="center")
     * @Assert\Valid()
     */
    private $celebrations;
    
    
    /**
     * is located by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="centers", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $location;
    
    
    /**
     * add
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\LocationBundle\Entity\Location", mappedBy="centerCreator")
     * @Assert\Valid()
     */
    private $locationCreated;
     
    
    /**
     * owns
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", mappedBy="center")
     * @Assert\Valid()
     */
    private $bands;
    
    
    /**
     * is composed by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Base", mappedBy="center")
     * @Assert\Valid()
     */
    private $bases;
    
    
    /**
     * wrote
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\ArticleBundle\Entity\Article", mappedBy="center")
     * @Assert\Valid()
     */
    private $articles;
    
    
    /**
     * presents
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", inversedBy="centers")
     */
    private $events;
    
    
    /**
     * is presented by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PageBundle\Entity\Page", mappedBy="center")
     * @Assert\Valid()
     */
    private $pages;


    /**
     * is advertised by
     *
     * @ORM\OneToMany(targetEntity="gospelcenter\ArticleBundle\Entity\Ad", mappedBy="center")
     * @Assert\Valid()
     */
    private $ads;
    
    
    /**
     * publishes
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\ImageBundle\Entity\Image", mappedBy="centerCreator")
     * @Assert\Valid()
     */
    private $images;
    
    
    /**
     * is described by
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="center", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;
    
    
    /**
     * is visited by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Visitor", inversedBy="centers")
     * @Assert\Valid()
     */
    private $visitors;
    
    
    /**
     * creates
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="center", cascade={"detach"})
     * @Assert\Valid()
     */
    private $persons;
    
    
    /**
     * is populated by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Member", inversedBy="centers")
     * @Assert\Valid()
     */
    private $members;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visitors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ads = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Center
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location = null)
    {
        $this->location = $location;
        $location->addCenter($this);
        
        if($location != null) {
            $name = "Gospel Center ". $this->name;
            $this->location->setName($name);
        }
    
        return $this;
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
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Center
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        
        if($image != null) {
            $this->image->setTitle("Gospel Center ".$this->name);
            $this->image->setType('Center');

            $image->setCenter($this);
        }
    
        return $this;
    }

    public function getDomain()
    {
        if($this->online) {
            $domain = "org";
        } else {
            $domain = "gospel-center.org";
        }

        return $domain;
    }
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/


    /**
     * Set ref
     *
     * @param string $ref
     * @return Center
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Center
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
     * Set online
     *
     * @param string $online
     * @return Center
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return string
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Center
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
     * @return Center
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
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Center
     */
    public function addCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebrations)
    {
        $this->celebrations[] = $celebrations;
    
        return $this;
    }

    /**
     * Remove celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     */
    public function removeCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebrations)
    {
        $this->celebrations->removeElement($celebrations);
    }

    /**
     * Get celebrations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCelebrations()
    {
        return $this->celebrations;
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
     * Add locationCreated
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $locationCreated
     * @return Center
     */
    public function addLocationCreated(\gospelcenter\LocationBundle\Entity\Location $locationCreated)
    {
        $this->locationCreated[] = $locationCreated;
    
        return $this;
    }

    /**
     * Remove locationCreated
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $locationCreated
     */
    public function removeLocationCreated(\gospelcenter\LocationBundle\Entity\Location $locationCreated)
    {
        $this->locationCreated->removeElement($locationCreated);
    }

    /**
     * Get locationCreated
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocationCreated()
    {
        return $this->locationCreated;
    }

    /**
     * Add bands
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bands
     * @return Center
     */
    public function addBand(\gospelcenter\CenterBundle\Entity\Band $bands)
    {
        $this->bands[] = $bands;
    
        return $this;
    }

    /**
     * Remove bands
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bands
     */
    public function removeBand(\gospelcenter\CenterBundle\Entity\Band $bands)
    {
        $this->bands->removeElement($bands);
    }

    /**
     * Get bands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * Add bases
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $bases
     * @return Center
     */
    public function addBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->bases[] = $bases;
    
        return $this;
    }

    /**
     * Remove bases
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $bases
     */
    public function removeBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->bases->removeElement($bases);
    }

    /**
     * Get bases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBases()
    {
        return $this->bases;
    }

    /**
     * Add articles
     *
     * @param \gospelcenter\ArticleBundle\Entity\Article $articles
     * @return Center
     */
    public function addArticle(\gospelcenter\ArticleBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \gospelcenter\ArticleBundle\Entity\Article $articles
     */
    public function removeArticle(\gospelcenter\ArticleBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add events
     *
     * @param \gospelcenter\EventBundle\Entity\Event $events
     * @return Center
     */
    public function addEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \gospelcenter\EventBundle\Entity\Event $events
     */
    public function removeEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add pages
     *
     * @param \gospelcenter\PageBundle\Entity\Page $pages
     * @return Center
     */
    public function addPage(\gospelcenter\PageBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
    
        return $this;
    }

    /**
     * Remove pages
     *
     * @param \gospelcenter\PageBundle\Entity\Page $pages
     */
    public function removePage(\gospelcenter\PageBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Add ads
     *
     * @param \gospelcenter\ArticleBundle\Entity\Ad $ads
     * @return Center
     */
    public function addAd(\gospelcenter\ArticleBundle\Entity\Ad $ads)
    {
        $this->ads[] = $ads;
    
        return $this;
    }

    /**
     * Remove ads
     *
     * @param \gospelcenter\ArticleBundle\Entity\Ad $ads
     */
    public function removeAd(\gospelcenter\ArticleBundle\Entity\Ad $ads)
    {
        $this->ads->removeElement($ads);
    }

    /**
     * Get ads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAds()
    {
        return $this->ads;
    }

    /**
     * Add images
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $images
     * @return Center
     */
    public function addImage(\gospelcenter\ImageBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $images
     */
    public function removeImage(\gospelcenter\ImageBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
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
     * Add visitors
     *
     * @param \gospelcenter\CenterBundle\Entity\Visitor $visitors
     * @return Center
     */
    public function addVisitor(\gospelcenter\CenterBundle\Entity\Visitor $visitors)
    {
        $this->visitors[] = $visitors;
    
        return $this;
    }

    /**
     * Remove visitors
     *
     * @param \gospelcenter\CenterBundle\Entity\Visitor $visitors
     */
    public function removeVisitor(\gospelcenter\CenterBundle\Entity\Visitor $visitors)
    {
        $this->visitors->removeElement($visitors);
    }

    /**
     * Get visitors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Add persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     * @return Center
     */
    public function addPerson(\gospelcenter\PeopleBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;
    
        return $this;
    }

    /**
     * Remove persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     */
    public function removePerson(\gospelcenter\PeopleBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Add members
     *
     * @param \gospelcenter\CenterBundle\Entity\Member $members
     * @return Center
     */
    public function addMember(\gospelcenter\CenterBundle\Entity\Member $members)
    {
        $this->members[] = $members;
    
        return $this;
    }

    /**
     * Remove members
     *
     * @param \gospelcenter\CenterBundle\Entity\Member $members
     */
    public function removeMember(\gospelcenter\CenterBundle\Entity\Member $members)
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
}