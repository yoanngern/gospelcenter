<?php

namespace gospelcenter\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="gospelcenter\LocationBundle\Entity\LocationRepository")
 */
class Location
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var integer
     *
     * @ORM\Column(name="postalCode", type="integer")
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;
    
    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;
    
    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;
    
     
    /**
     * locates
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Center", mappedBy="location")
     */
     private $centers;
     
     
    /**
     * situates
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="location")
     */
    private $celebrations;
     
     
    /**
     * hosts
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\EventBundle\Entity\Event", mappedBy="location")
     */
    private $events;
     
     
    /**
     * gathered
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\CenterBundle\Entity\Base", mappedBy="location")
     */
    private $bases;
    
    
    /**
     * is leved by
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="location")
     */
    private $persons;
     
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Location
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
     * Set address1
     *
     * @param string $address1
     * @return Location
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    
        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Location
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    
        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set postalCode
     *
     * @param integer $postalCode
     * @return Location
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return integer 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Location
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Add centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     * @return Location
     */
    public function addCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers[] = $centers;
    
        return $this;
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

    /**
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Location
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
     * Add events
     *
     * @param \gospelcenter\EventBundle\Entity\Event $events
     * @return Location
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
     * Add bases
     *
     * @param \gospelcenter\CenterBundle\Entity\Base $bases
     * @return Location
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

    /**
     * Add persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     * @return Location
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
}