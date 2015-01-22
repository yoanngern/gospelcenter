<?php

namespace gospelcenter\CelebrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use gospelcenter\PeopleBundle\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Speaker
 *
 * @ORM\Table(name="speaker")
 * @ORM\Entity(repositoryClass="gospelcenter\CelebrationBundle\Entity\SpeakerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Speaker
{

    /**
     * is a child of a Person
     * 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="speaker", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, name="id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $person;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SpeakerFromDate", type="date")
     * @Assert\DateTime()
     */
    private $speakerFromDate;
    
    
    /**
     * preaches
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", mappedBy="speakers")
     * @Assert\Valid()
     */
    private $celebrations;
    
    
    /**
     * Constructor
     */
    public function __construct(Person $person)
    {

        $this->setPerson($person);

        $this->celebrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->speakerFromDate = new \Datetime();
    }
    
    
    public function getSelect()
    {
        $firstname = $this->person->getFirstname();
        $lastname = $this->person->getLastname();
        $name = $firstname. " " .$lastname;
        
        return $name;
    }

    /**
     * Set person
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $person
     * @return Speaker
     */
    public function setPerson(\gospelcenter\PeopleBundle\Entity\Person $person)
    {
        $this->person = $person;
        $person->setSpeaker($this);

        return $this;
    }
    
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/
    
    

    /**
     * Set speakerFromDate
     *
     * @param \DateTime $speakerFromDate
     * @return Speaker
     */
    public function setSpeakerFromDate($speakerFromDate)
    {
        $this->speakerFromDate = $speakerFromDate;
    
        return $this;
    }

    /**
     * Get speakerFromDate
     *
     * @return \DateTime 
     */
    public function getSpeakerFromDate()
    {
        return $this->speakerFromDate;
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
     * Add celebrations
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebrations
     * @return Speaker
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
}