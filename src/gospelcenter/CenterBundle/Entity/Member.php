<?php

namespace gospelcenter\CenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Member
 *
 * @ORM\Table(name="member")
 * @ORM\Entity(repositoryClass="gospelcenter\CenterBundle\Entity\MemberRepository")
 */
class Member
{   
    
    /**
     * is a child of a Person
     * 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="gospelcenter\PeopleBundle\Entity\Person", inversedBy="member")
     * @ORM\JoinColumn(nullable=false, name="id", referencedColumnName="id")
     */
    private $person;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MemberFromDate", type="date")
     */
    private $memberFromDate;
    
    /**
     * is member of
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\CenterBundle\Entity\Center", mappedBy="members")
     */
    private $centers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->memberFromDate = new \Datetime();
    }

    /**
     * Set memberFromDate
     *
     * @param \DateTime $memberFromDate
     * @return Member
     */
    public function setMemberFromDate($memberFromDate)
    {
        $this->memberFromDate = $memberFromDate;
    
        return $this;
    }

    /**
     * Get memberFromDate
     *
     * @return \DateTime 
     */
    public function getMemberFromDate()
    {
        return $this->memberFromDate;
    }

    /**
     * Set person
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $person
     * @return Member
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
     * Add centers
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $centers
     * @return Member
     */
    public function addCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->centers[] = $centers;
        $centers->addMember($this);
    
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
}