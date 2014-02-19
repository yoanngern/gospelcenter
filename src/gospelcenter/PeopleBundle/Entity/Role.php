<?php

namespace gospelcenter\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="gospelcenter\PeopleBundle\Entity\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;
    
    
    /**
     * works for
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="roles")
     */
    private $celebrations;
    
    
    /**
     * is managed by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Band", inversedBy="roles")
     */
    private $bands;
    
    
    /**
     * is played by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="roles")
     */
    private $persons;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Role
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
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Role
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
     * Add bands
     *
     * @param \gospelcenter\CenterBundle\Entity\Band $bands
     * @return Role
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
     * Add persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     * @return Role
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