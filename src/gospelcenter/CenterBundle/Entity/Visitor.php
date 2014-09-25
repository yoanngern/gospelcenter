<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Visitor
 *
 * @ORM\Table(name="visitor")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\VisitorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Visitor
{
    
    /**
     * is a child of a Person
     * 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="visitor")
     * @ORM\JoinColumn(nullable=false, name="id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $person;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Frequency", type="string", length=255, nullable=true)
     * @Assert\DateTime()
     */
    private $frequency;

    /**
     * @var string
     *
     * @ORM\Column(name="AttendedChurch", type="string", length=255, nullable=true)
     */
    private $attendedChurch;
    
    /**
     * visites
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Center", mappedBy="visitors")
     * @Assert\Valid()
     */
    private $centers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     * @return Visitor
     */
    public function addCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers[] = $centers;
        $centers->addVisitor($this);
    
        return $this;
    }
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/


    /**
     * Set frequency
     *
     * @param string $frequency
     * @return Visitor
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    
        return $this;
    }

    /**
     * Get frequency
     *
     * @return string 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set attendedChurch
     *
     * @param string $attendedChurch
     * @return Visitor
     */
    public function setAttendedChurch($attendedChurch)
    {
        $this->attendedChurch = $attendedChurch;
    
        return $this;
    }

    /**
     * Get attendedChurch
     *
     * @return string 
     */
    public function getAttendedChurch()
    {
        return $this->attendedChurch;
    }

    /**
     * Set person
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $person
     * @return Visitor
     */
    public function setPerson(\gospelcenter\PeopleBundle\Entity\Person $person)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return \gospelcenter\PeopleBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    

    /**
     * Remove centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     */
    public function removeCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers->removeElement($centers);
    }

    /**
     * Get centers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCenters()
    {
        return $this->centers;
    }
}