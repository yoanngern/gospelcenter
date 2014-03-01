<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audio
 *
 * @ORM\Table(name="audio")
 * @ORM\Entity(repositoryClass="gospelcenter\MediaBundle\Entity\AudioRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Audio
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
     * @ORM\Column(name="soundCloudId", type="integer")
     */
    private $soundCloudId;
    
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
     * spreads
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", inversedBy="audio")
     * @ORM\JoinColumn(nullable=false)
     */
    private $celebration;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();
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
     * Set soundCloudId
     *
     * @param integer $soundCloudId
     * @return Audio
     */
    public function setSoundCloudId($soundCloudId)
    {
        $this->soundCloudId = $soundCloudId;
    
        return $this;
    }

    /**
     * Get soundCloudId
     *
     * @return integer 
     */
    public function getSoundCloudId()
    {
        return $this->soundCloudId;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Audio
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
     * @return Audio
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
     * Set celebration
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebration
     * @return Audio
     */
    public function setCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebration)
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