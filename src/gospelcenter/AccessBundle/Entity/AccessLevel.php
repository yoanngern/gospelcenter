<?php

namespace gospelcenter\AccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AccessLevel
 *
 * @ORM\Table(name="accessLevel")
 * @ORM\Entity(repositoryClass="gospelcenter\AccessBundle\Entity\AccessLevelRepository")
 */
class AccessLevel
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
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;
    
    /**
     * is granted to (intermediate)
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\AccessBundle\Entity\Access", inversedBy="accessLevels")
     * @Assert\Valid()
     */
    private $access;
    
    /**
     * is given (intermediate)
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\AccessBundle\Entity\Unit", inversedBy="accessLevels")
     * @Assert\Valid()
     */
    private $unit;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
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
     * Set level
     *
     * @param string $level
     * @return AccessLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set access
     *
     * @param \gospelcenter\AccessBundle\Entity\Access $access
     * @return AccessLevel
     */
    public function setAccess(\gospelcenter\AccessBundle\Entity\Access $access = null)
    {
        $this->access = $access;
    
        return $this;
    }

    /**
     * Get access
     *
     * @return \gospelcenter\AccessBundle\Entity\Access 
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set unit
     *
     * @param \gospelcenter\AccessBundle\Entity\Unit $unit
     * @return AccessLevel
     */
    public function setUnit(\gospelcenter\AccessBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return \gospelcenter\AccessBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}