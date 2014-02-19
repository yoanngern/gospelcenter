<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Base
 *
 * @ORM\Table(name="base")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\BaseRepository")
 */
class Base
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
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;
    
    
    /**
     * composes
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="bases")
     */
    private $center;
    
    
    /**
     * is participated by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="baseParticipated")
     */
    private $participants;
    
    
    /**
     * is organized by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="baseOrganized")
     */
    private $organizers;
    
    
    /**
     * meets to
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="bases")
     */
    private $location;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->organizers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Base
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
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Base
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
     * Add participants
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $participants
     * @return Base
     */
    public function addParticipant(\gospelcenter\PeopleBundle\Entity\Person $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $participants
     */
    public function removeParticipant(\gospelcenter\PeopleBundle\Entity\Person $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add organizers
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $organizers
     * @return Base
     */
    public function addOrganizer(\gospelcenter\PeopleBundle\Entity\Person $organizers)
    {
        $this->organizers[] = $organizers;
    
        return $this;
    }

    /**
     * Remove organizers
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $organizers
     */
    public function removeOrganizer(\gospelcenter\PeopleBundle\Entity\Person $organizers)
    {
        $this->organizers->removeElement($organizers);
    }

    /**
     * Get organizers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganizers()
    {
        return $this->organizers;
    }

    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Base
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return \gospelcenter\LocationBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}