<?php

namespace gospelcenter\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="gospelcenter\ArticleBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Article
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
     * @Assert\NotBlank(message="Please enter an introduction text.")
     */
    private $introText;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     * @Assert\NotBlank(message="Please select a template.")
     */
    private $template;

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
     * is written by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="articles")
     * @Assert\Valid()
     */
    private $center;
    
    
    /**
     * shows
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\MediaBundle\Entity\Video", inversedBy="articles")
     * @Assert\Valid()
     */
    private $video;
    
    
    /**
     * contains
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="articles")
     * @Assert\Valid()
     */
    private $image;
    
    
    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center = null)
    {
        $this->status = true;
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Set template
     *
     * @param string $template
     * @return Article
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    
        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Set video
     *
     * @param \gospelcenter\MediaBundle\Entity\Video $video
     * @return Article
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
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
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
}