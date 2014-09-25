<?php

namespace gospelcenter\CelebrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use gospelcenter\DateBundle\Entity\Date;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Celebration
 *
 * @ORM\Table(name="celebration")
 * @ORM\Entity(repositoryClass="gospelcenter\CelebrationBundle\Entity\CelebrationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Celebration
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bestOf", type="boolean")
     */
    private $bestOf;

    /**
     * @var boolean
     *
     * @ORM\Column(name="kidsProgram", type="boolean")
     */
    private $kidsProgram;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     * @Assert\DateTime()
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime")
     * @Assert\DateTime()
     */
    private $modifiedDate;


    private $existingSpeakers;
    private $newSpeakers;
    private $startingTime;
    private $endingTime;
    private $dateLocal;


    /**
     * is composed by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\PeopleBundle\Entity\Role", inversedBy="celebrations")
     * @Assert\Valid()
     */
    private $roles;


    /**
     * is spreader by
     *
     * @ORM\OneToOne(targetEntity="gospelcenter\MediaBundle\Entity\Audio", mappedBy="celebration", cascade={"persist", "remove"})
     */
    private $audio;


    /**
     * is tagged by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Tag", inversedBy="celebrations")
     * @Assert\Valid()
     */
    private $tags;


    /**
     * is situated by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\LocationBundle\Entity\Location", inversedBy="celebrations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $location;


    /**
     * diffuses
     *
     * @ORM\OneToOne(targetEntity="gospelcenter\MediaBundle\Entity\Video", inversedBy="celebration", cascade={"persist", "remove"})
     */
    private $video;


    /**
     * is at
     *
     * @ORM\OneToOne(targetEntity="gospelcenter\DateBundle\Entity\Date", mappedBy="celebration", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $date;


    /**
     * is organized by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\CenterBundle\Entity\Center", inversedBy="celebrations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $center;


    /**
     * is imaged by
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\ImageBundle\Entity\Image", inversedBy="celebrations", cascade={"persist", "detach"})
     * @Assert\Valid()
     */
    private $image;


    /**
     * is preached by
     *
     * @ORM\ManyToMany(targetEntity="gospelcenter\CelebrationBundle\Entity\Speaker", inversedBy="celebrations", cascade={"persist"})
     * @Assert\Valid()
     */
    private $speakers;


    /**
     * Constructor
     */
    public function __construct(\gospelcenter\CenterBundle\Entity\Center $center)
    {
        $this->status = true;
        $this->createdDate = new \Datetime();
        $this->modifiedDate = new \Datetime();

        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->speakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->existingSpeakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->newSpeakers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->center = $center;
    }


    public function setExistingSpeakers($existingSpeakers)
    {
        $this->existingSpeakers = $existingSpeakers;

        return $this;
    }


    public function getExistingSpeakers()
    {
        return $this->existingSpeakers;
    }

    public function setNewSpeakers($newSpeakers)
    {
        $this->newSpeakers = $newSpeakers;

        return $this;
    }


    public function getNewSpeakers()
    {
        return $this->newSpeakers;
    }


    public function setStartingTime($startingTime)
    {
        $this->startingTime = $startingTime;

        return $this;
    }


    public function getStartingTime()
    {
        return $this->startingTime;
    }


    public function setEndingTime($endingTime)
    {
        $this->endingTime = $endingTime;

        return $this;
    }


    public function getEndingTime()
    {
        return $this->endingTime;
    }


    public function setDateLocal($dateLocal)
    {
        $this->dateLocal = $dateLocal;

        return $this;
    }


    public function getDateLocal()
    {
        return $this->dateLocal;
    }


    /**
     * Set image
     *
     * @param \gospelcenter\ImageBundle\Entity\Image $image
     * @return Celebration
     */
    public function setImage(\gospelcenter\ImageBundle\Entity\Image $image)
    {
        $this->image = $image;

        if ($image != null) {
            $title = "Celebration of ";
            $title .= date_format($this->dateLocal, 'j F Y');

            $speakers = $this->getSpeakers();

            if ($speakers != null) {
                $title .= " with ";

                foreach ($speakers as $speaker) {
                    $title .= $speaker->getPerson()->getFirstname();
                    $title .= " ";
                    $title .= $speaker->getPerson()->getLastname();
                }
            }

            $this->image->setTitle($title);
            $this->image->setType('Celebration');
        }

        return $this;
    }

    /**
     * Set video
     *
     * @param \gospelcenter\MediaBundle\Entity\Video $video
     * @return Celebration
     */
    public function setVideo(\gospelcenter\MediaBundle\Entity\Video $video = null)
    {
        $this->video = $video;
        $video->setCelebration($this);

        return $this;
    }

    /**
     *
     */
    public function updateDate()
    {

        $date = $this->date;;

        $startingDate = date_create($this->dateLocal->format('Y-m-d'));
        $startingDate->setTime($this->startingTime->format('H'), $this->startingTime->format('i'));

        $endingDate = date_create($this->dateLocal->format('Y-m-d'));
        $endingDate->setTime($this->endingTime->format('H'), $this->endingTime->format('i'));

        $date->setStart($startingDate);
        $date->setEnd($endingDate);

        //$this->setDate($date);

    }

    /**
     * Set audio
     *
     * @param \gospelcenter\MediaBundle\Entity\Audio $audio
     * @return Celebration
     */
    public function setAudio(\gospelcenter\MediaBundle\Entity\Audio $audio = null)
    {
        $this->audio = $audio;
        $audio->setCelebration($this);

        return $this;
    }


    /**
     * Set date
     *
     * @param \gospelcenter\DateBundle\Entity\Date $date
     * @return Celebration
     */
    public function setDate(\gospelcenter\DateBundle\Entity\Date $date = null)
    {
        $this->date = $date;

        $date->setCelebration($this);

        return $this;
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
     * Set title
     *
     * @param string $title
     * @return Celebration
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
     * Set description
     *
     * @param string $description
     * @return Celebration
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Celebration
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set bestOf
     *
     * @param boolean $bestOf
     * @return Celebration
     */
    public function setBestOf($bestOf)
    {
        $this->bestOf = $bestOf;

        return $this;
    }

    /**
     * Get bestOf
     *
     * @return boolean
     */
    public function getBestOf()
    {
        return $this->bestOf;
    }

    /**
     * Set kidsProgram
     *
     * @param boolean $kidsProgram
     * @return Celebration
     */
    public function setKidsProgram($kidsProgram)
    {
        $this->kidsProgram = $kidsProgram;

        return $this;
    }

    /**
     * Get kidsProgram
     *
     * @return boolean
     */
    public function getKidsProgram()
    {
        return $this->kidsProgram;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Celebration
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Celebration
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Add roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     * @return Celebration
     */
    public function addRole(\gospelcenter\PeopleBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \gospelcenter\PeopleBundle\Entity\Role $roles
     */
    public function removeRole(\gospelcenter\PeopleBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get audio
     *
     * @return \gospelcenter\MediaBundle\Entity\Audio
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * Add tags
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Tag $tags
     * @return Celebration
     */
    public function addTag(\gospelcenter\CelebrationBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Tag $tags
     */
    public function removeTag(\gospelcenter\CelebrationBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set location
     *
     * @param \gospelcenter\LocationBundle\Entity\Location $location
     * @return Celebration
     */
    public function setLocation(\gospelcenter\LocationBundle\Entity\Location $location)
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

    /**
     * Get video
     *
     * @return \gospelcenter\MediaBundle\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }


    /**
     * Get date
     *
     * @return \gospelcenter\DateBundle\Entity\Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set center
     *
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @return Celebration
     */
    public function setCenter(\gospelcenter\CenterBundle\Entity\Center $center)
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
     * Get image
     *
     * @return \gospelcenter\ImageBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add speakers
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Speaker $speakers
     * @return Celebration
     */
    public function addSpeaker(\gospelcenter\CelebrationBundle\Entity\Speaker $speakers)
    {
        $this->speakers[] = $speakers;

        return $this;
    }

    /**
     * Remove speakers
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Speaker $speakers
     */
    public function removeSpeaker(\gospelcenter\CelebrationBundle\Entity\Speaker $speakers)
    {
        $this->speakers->removeElement($speakers);
    }

    /**
     * Get speakers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }
}