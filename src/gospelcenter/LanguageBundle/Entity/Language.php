<?php

namespace gospelcenter\LanguageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="gospelcenter\LanguageBundle\Entity\LanguageRepository")
 */
class Language
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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;
    
    /**
     * is spoken by
     * 
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Person", mappedBy="languages")
     */
    private $persons;
    
    /**
     * specifies
     * 
     * @ORM\OneToMany(targetEntity="gospelcenter\PageBundle\Entity\Page", mappedBy="languages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pages;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /*************************************/
    /**** Getter setter auto generate ****/
    /*************************************/
    
    

    /**
     * Set ref
     *
     * @param string $ref
     * @return Language
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
     * Set value
     *
     * @param string $value
     * @return Language
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add persons
     *
     * @param \gospelcenter\PeopleBundle\Entity\Person $persons
     * @return Language
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

    /**
     * Add pages
     *
     * @param \gospelcenter\PageBundle\Entity\Page $pages
     * @return Language
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
}