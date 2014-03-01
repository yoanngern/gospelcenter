<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="gospelcenter\MediaBundle\Entity\VideoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Video
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
     * @var integer
     *
     * @ORM\Column(name="ownerId", type="integer")
     */
    private $ownerId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $owner;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     */
    private $modifiedDate;
    
    /**
     * is shown by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\ArticleBundle\Entity\Article", mappedBy="video")
     */
    private $articles;
    
    /**
     * is used by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", mappedBy="video")
     */
    private $events;
    
    /**
     * is diffused by
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", inversedBy="video")
     */
    private $celebration;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ownerId
     *
     * @param integer $ownerId
     * @return Video
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    
        return $this;
    }

    /**
     * Get ownerId
     *
     * @return integer 
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Set owner
     *
     * @param string $owner
     * @return Video
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Video
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
     * @return Video
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
     * Add articles
     *
     * @param \gospelcenter\ArticleBundle\Entity\Article $articles
     * @return Video
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
     * @return Video
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
     * Set celebration
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebration
     * @return Video
     */
    public function setCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebration = null)
    {
        $this->celebration = $celebration;
    
        return $this;
    }

    /**
     * Get celebration
     *
     * @return \gospelcenter\CelebrationBundle\Entity\Celebration 
     */
    public function getCelebration()
    {
        return $this->celebration;
    }
}