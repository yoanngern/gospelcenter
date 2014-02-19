<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audio
 *
 * @ORM\Table(name="audio")
 * @ORM\Entity(repositoryClass="gospelcenter\MediaBundle\Entity\AudioRepository")
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
        
    }

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