<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * spreads
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", inversedBy="audio")
     * @ORM\JoinColumn(nullable=false)
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
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSave()
    {

        $this->modifiedDate = new \Datetime();

        $this->owner = "soundcloud";

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
     * @return Audio
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
     * @return Audio
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