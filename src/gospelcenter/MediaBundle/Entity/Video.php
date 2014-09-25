<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="ownerId", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $ownerId;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\Url()
     */
    private $url;

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
     * is shown by
     *
     * @ORM\OneToMany(targetEntity="gospelcenter\ArticleBundle\Entity\Article", mappedBy="video")
     * @Assert\Valid()
     */
    private $articles;

    /**
     * is used by
     *
     * @ORM\OneToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", mappedBy="video")
     * @Assert\Valid()
     */
    private $events;

    /**
     * is diffused by
     *
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="video", cascade={"persist", "remove"})
     * @Assert\Valid()
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

        $tmp = parse_url($this->url);
        $hostname = $tmp["host"];

        if (strpos($hostname, "youtube.com") !== false) {
            $this->owner = "youtube";

            $regExp = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";

            preg_match($regExp, $this->url, $matches);

            $this->ownerId = $matches[7];

        }

        if (strpos($hostname, "vimeo.com") !== false) {
            $this->owner = "vimeo";

            $regExp = "/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/";

            preg_match($regExp, $this->url, $matches);

            $this->ownerId = $matches[3];

        }


        if (strpos($hostname, "dailymotion.com") !== false) {
            $this->owner = "dailymotion";

            $regExp = "/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/";

            preg_match($regExp, $this->url, $matches);

            if (count($matches) > 3) {
                $this->ownerId = $matches[4];
            } else {
                $this->ownerId = $matches[2];
            }
        }

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
     * @param string $ownerId
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
     * @return string
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
     * Set url
     *
     * @param string $url
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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