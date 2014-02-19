<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Center
 *
 * @ORM\Table(name="center")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\CenterRepository")
 */
class Center
{

    /**
     * @var string
     * 
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    
    /**
     * presents
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", inversedBy="centers")
     */
     private $events;
     
     
    /**
     * is located by
     * 
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="centers", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
     private $location;
    
    
    /**
     * organizes
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="center")
     */
    private $celebrations;
    
    
    /**
     * is presented by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PageBundle\Entity\Page", mappedBy="center")
     */
    private $pages;
    
    
    /**
     * is populated by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Member", inversedBy="centers")
     */
    private $members;
    
    
    /**
     * is visited by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Visitor", inversedBy="centers")
     */
    private $visitors;
    
    
    /**
     * owns
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", mappedBy="center")
     */
    private $bands;
    
    
    /**
     * is composed by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Base", mappedBy="center")
     */
    private $bases;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visitors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bases = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Center
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location = null)
    {
        $this->location = $location;
        
        if($location != null) {
            $name = "Gospel Center ". $this->name;
            $this->location->setName($name);
        }
    
        return $this;
    }
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/
    
    

    /**
     * Set ref
     *
     * @param string $ref
     * @return Center
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Center
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add events
     *
     * @param \gospelcenter\EventBundle\Entity\Event $events
     * @return Center
     */
    public function addEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \gospelcenter\EventBundle\Entity\Event $events
     */
    public function removeEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
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

    /**
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Center
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
     * Add pages
     *
     * @param \gospelcenter\PageBundle\Entity\Page $pages
     * @return Center
     */
    public function addPage(\gospelcenter\PageBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
    
        return $this;
    }

    /**
     * Remove pages
     *
     * @param \gospelcenter\PageBundle\Entity\Page $pages
     */
    public function removePage(\gospelcenter\PageBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Add members
     *
     * @param \gospelcenter\CenterBundle\Entity\Member $members
     * @return Center
     */
    public function addMember(\gospelcenter\CenterBundle\Entity\Member $members)
    {
        $this->members[] = $members;
    
        return $this;
    }

    /**
     * Remove members
     *
     * @param \gospelcenter\CenterBundle\Entity\Member $members
     */
    public function removeMember(\gospelcenter\CenterBundle\Entity\Member $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add visitors
     *
     * @param \gospelcenter\CenterBundle\Entity\Visitor $visitors
     * @return Center
     */
    public function addVisitor(\gospelcenter\CenterBundle\Entity\Visitor $visitors)
    {
        $this->visitors[] = $visitors;
    
        return $this;
    }

    /**
     * Remove visitors
     *
     * @param \gospelcenter\CenterBundle\Entity\Visitor $visitors
     */
    public function removeVisitor(\gospelcenter\CenterBundle\Entity\Visitor $visitors)
    {
        $this->visitors->removeElement($visitors);
    }

    /**
     * Get visitors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Add bands
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bands
     * @return Center
     */
    public function addBand(\gospelcenter\CenterBundle\Entity\Band $bands)
    {
        $this->bands[] = $bands;
    
        return $this;
    }

    /**
     * Remove bands
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bands
     */
    public function removeBand(\gospelcenter\CenterBundle\Entity\Band $bands)
    {
        $this->bands->removeElement($bands);
    }

    /**
     * Get bands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * Add bases
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $bases
     * @return Center
     */
    public function addBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->bases[] = $bases;
    
        return $this;
    }

    /**
     * Remove bases
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $bases
     */
    public function removeBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->bases->removeElement($bases);
    }

    /**
     * Get bases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBases()
    {
        return $this->bases;
    }
}