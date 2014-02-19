<?php

namespace gospelcenter\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="gospelcenter\MediaBundle\Entity\VideoRepository")
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
     * @ORM\Column(name="vimeoId", type="integer")
     */
    private $vimeoId;
    
    
    /**
     * diffuses
     * 
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", inversedBy="video")
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
     * Set vimeoId
     *
     * @param integer $vimeoId
     * @return Video
     */
    public function setVimeoId($vimeoId)
    {
        $this->vimeoId = $vimeoId;
    
        return $this;
    }

    /**
     * Get vimeoId
     *
     * @return integer 
     */
    public function getVimeoId()
    {
        return $this->vimeoId;
    }

    /**
     * Set celebration
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebration
     * @return Video
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