<?php

namespace gospelcenter\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="gospelcenter\ImageBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="originalName", type="string", length=255)
     */
    private $originalName;
    
    
    private $file;
    
    private $tempFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    
    /**
     * images
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="image")
     */
    private $celebrations;
    
    
    /**
     * illustrates
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", mappedBy="picture")
     */
    private $eventsPicture;
    
    
    /**
     * covers
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", mappedBy="cover")
     */
    private $eventsCover;
    
    
    /**
     * shows
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="image")
     */
    private $persons;
    
     
    /**
     * is used by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PageBundle\Entity\Slide", mappedBy="image")
     */
    private $slides;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \Datetime();
        $this->eventsPicture = new \Doctrine\Common\Collections\ArrayCollection();
        $this->eventsCover = new \Doctrine\Common\Collections\ArrayCollection();
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        
        if($this->extension !== null) {
            $this->tempFilename = $this->extension;
            
            $this->extension = null;
            $this->originalName = null;
        }
    }
    
    
    public function getFile()
    {
        return $this->file;
    }
    
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        
        if($this->file === null) {
            return;
        }
        
        $this->extension = $this->file->guessExtension();
        
        $this->originalName = $this->file->getClientOriginalName();
        
        $this->alt = $this->title;
    }
    
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if($this->file === null) {
            return;
        }
        
        if($this->createdDate !== null) {
            $date = $this->createdDate;
        } else {
            $date = new \Datetime();
        }
             
        $createdDate = date_format($date, 'Y_m_d');
        
        if($this->tempFilename !== null) {
            $oldFile = $this->getUploadRootDir().'/'.$createdDate.'_'.$this->id.'.'.$this->extension;
            if(file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        
        $this->file->move(
            $this->getUploadRootDir(),
            $createdDate.'_'.$this->id.'.'.$this->extension
        );
    }
    
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $createdDate = date_format($this->createdDate, 'Y_m_d');
        
        $this->tempFilename = $this->getUploadRootDir().$createdDate.'_'.$this->id.'.'.$this->extension;
    }
    
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($this->tempFilenmae)) {
            unlink($this->tempFilename);
        }
    }
    
    
    public function getUploadDir()
    {
        return 'uploads/images';
    }
    
    
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    public function getWebPath()
    {
        $createdDate = date_format($this->createdDate, 'Y_m_d');
        return $this->getUploadDir().'/'.$createdDate.'_'.$this->id.'.'.$this->extension;
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
     * @return Image
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Image
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
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Image
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
     * Set originalName
     *
     * @param string $originalName
     * @return Image
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    
        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
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
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Image
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
     * Add eventsPicture
     *
     * @param \gospelcenter\EventBundle\Entity\Event $eventsPicture
     * @return Image
     */
    public function addEventsPicture(\gospelcenter\EventBundle\Entity\Event $eventsPicture)
    {
        $this->eventsPicture[] = $eventsPicture;
    
        return $this;
    }

    /**
     * Remove eventsPicture
     *
     * @param \gospelcenter\EventBundle\Entity\Event $eventsPicture
     */
    public function removeEventsPicture(\gospelcenter\EventBundle\Entity\Event $eventsPicture)
    {
        $this->eventsPicture->removeElement($eventsPicture);
    }

    /**
     * Get eventsPicture
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEventsPicture()
    {
        return $this->eventsPicture;
    }

    /**
     * Add eventsCover
     *
     * @param \gospelcenter\EventBundle\Entity\Event $eventsCover
     * @return Image
     */
    public function addEventsCover(\gospelcenter\EventBundle\Entity\Event $eventsCover)
    {
        $this->eventsCover[] = $eventsCover;
    
        return $this;
    }

    /**
     * Remove eventsCover
     *
     * @param \gospelcenter\EventBundle\Entity\Event $eventsCover
     */
    public function removeEventsCover(\gospelcenter\EventBundle\Entity\Event $eventsCover)
    {
        $this->eventsCover->removeElement($eventsCover);
    }

    /**
     * Get eventsCover
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEventsCover()
    {
        return $this->eventsCover;
    }

    /**
     * Add persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     * @return Image
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
     * Add slides
     *
     * @param \gospelcenter\PageBundle\Entity\Slide $slides
     * @return Image
     */
    public function addSlide(\gospelcenter\PageBundle\Entity\Slide $slides)
    {
        $this->slides[] = $slides;
    
        return $this;
    }

    /**
     * Remove slides
     *
     * @param \gospelcenter\PageBundle\Entity\Slide $slides
     */
    public function removeSlide(\gospelcenter\PageBundle\Entity\Slide $slides)
    {
        $this->slides->removeElement($slides);
    }

    /**
     * Get slides
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSlides()
    {
        return $this->slides;
    }
}