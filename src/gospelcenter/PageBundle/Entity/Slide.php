<?php

namespace gospelcenter\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Slide
 *
 * @ORM\Table(name="slide")
 * @ORM\Entity(repositoryClass="gospelcenter\PageBundle\Entity\SlideRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Slide
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
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     * @Assert\NotBlank(message="Please select a template.")
     */
    private $template;
    
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;
    
    /**
     * @var string
     *
     * @ORM\Column(name="labelLink", type="string", length=255, nullable=true)
     */
    private $labelLink;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showText", type="boolean")
     */
    private $showText;


    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     * @Assert\NotBlank()
     */
    private $sort; 

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
     * uses
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="slides", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * uses
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="slides", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $alphaImage;
    
    
    /**
     * is contained by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\PageBundle\Entity\Page", inversedBy="slides", cascade={"persist"})
     * @Assert\Valid()
     */
    private $page;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = true;
        $this->showText = true;
        $this->modifiedDate = new \Datetime();
        $this->createdDate = new \Datetime();
        $this->sort = 999;
    }
    
    /**
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Image
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        
        if($image != null) {
            $title = $this->title;
            $this->image->setTitle($title);
            $this->image->setType('Slide');

            $image->addSlide($this);
        }
    
        return $this;
    }

    /**
     * Set alphaImage
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $alphaImage
     * @return Image
     */
    public function setAlphaImage(\gospelcenter\ImageBundle\Entity\Image $alphaImage = null)
    {
        $this->alphaImage = $alphaImage;

        if($alphaImage != null) {
            $title = $this->title;
            $this->alphaImage->setTitle($title);
            $this->alphaImage->setType('Slide');

            $alphaImage->addSlide($this);
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
        
        if($this->sort === null) {
            $this->sort = 999;
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
     * Set title
     *
     * @param string $title
     * @return Slide
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
     * Set text
     *
     * @param string $text
     * @return Slide
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
     * Set link
     *
     * @param string $link
     * @return Slide
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set labelLink
     *
     * @param string $labelLink
     * @return Slide
     */
    public function setLabelLink($labelLink)
    {
        $this->labelLink = $labelLink;
    
        return $this;
    }

    /**
     * Get labelLink
     *
     * @return string 
     */
    public function getLabelLink()
    {
        return $this->labelLink;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Slide
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Slide
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
     * @return Slide
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
     * Get image
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set page
     *
     * @param \gospelcenter\PageBundle\Entity\Page $page
     * @return Slide
     */
    public function setPage(\gospelcenter\PageBundle\Entity\Page $page)
    {
        $this->page = $page;
    
        return $this;
    }

    /**
     * Get page
     *
     * @return \gospelcenter\PageBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Slide
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
     * Set showText
     *
     * @param boolean $showText
     * @return Slide
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
     * Get alphaImage
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getAlphaImage()
    {
        return $this->alphaImage;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Slide
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
}