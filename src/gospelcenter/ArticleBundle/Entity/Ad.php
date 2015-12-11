<?php

namespace gospelcenter\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ad
 *
 * @ORM\Table(name="ad")
 * @ORM\Entity(repositoryClass="gospelcenter\ArticleBundle\Entity\AdRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Ad
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
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\NotBlank(message="Please enter an URL.")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showText", type="boolean")
     */
    private $showText;

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
     * advertises
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="ads")
     * @Assert\Valid()
     */
    private $center;


    /**
     * is displayed by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="ads", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;


    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->status = true;
        $this->showText = true;
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();

        if($center != null){
            $this->center = $center;
        }
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
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Ad
     */
    public function setCenter(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->center = $center;
        $center->addAd($this);

        return $this;
    }

    /**
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Ad
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image)
    {
        $this->image = $image;

        if ($image != null) {

            $this->image->setTitle($this->title);
            $this->image->setType('Ad');

            $image->addAd($this);
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
     * Set status
     *
     * @param boolean $status
     * @return Ad
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
     * Set title
     *
     * @param string $title
     * @return Ad
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
     * Set subtitle
     *
     * @param string $subtitle
     * @return Ad
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    
        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Ad
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
     * Set type
     *
     * @param string $type
     * @return Ad
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set showText
     *
     * @param boolean $showText
     * @return Ad
     */
    public function setShowText($showText)
    {
        $this->showText = $showText;

        return $this;
    }

    /**
     * Get showText
     *
     * @return boolean
     */
    public function getShowText()
    {
        return $this->showText;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Ad
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
     * @return Ad
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
     * Get center
     *
     * @return \gospelcenter\CenterBundle\Entity\Center 
     */
    public function getCenter()
    {
        return $this->center;
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
}