<?php

namespace gospelcenter\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    
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
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     */
    private $modifiedDate;
    
    
    /**
     * is contained by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\PageBundle\Entity\Page", inversedBy="slides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;
    
    
    /**
     * uses
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="slides", cascade={"persist", "remove"})
     */
    private $image;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modifiedDate = new \Datetime();
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
        }
    
        return $this;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSave()
    {
        
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
     * Get image
     *
     * @return \gospelcenter\ImageBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}