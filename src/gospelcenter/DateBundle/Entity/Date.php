<?php

namespace gospelcenter\DateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Date
 *
 * @ORM\Table(name="date")
 * @ORM\Entity(repositoryClass="gospelcenter\DateBundle\Entity\DateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Date
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
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     * @Assert\DateTime()
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     * @Assert\DateTime()
     */
    private $end;

    private $startingTime;
    private $endingTime;
    private $oneDate;


    /**
     * has
     *
     * @ORM\ManyToOne(targetEntity="gospelcenter\EventBundle\Entity\Event", inversedBy="dates")
     * @Assert\Valid()
     */
    private $event;


    /**
     * contains
     *
     * @ORM\OneToOne(targetEntity="gospelcenter\CelebrationBundle\Entity\Celebration", inversedBy="date")
     * @Assert\Valid()
     */
    private $celebration;


    /**
     * Constructor
     */
    public function __construct()
    {

    }


    /**
     *
     */
    public function setStartEnd()
    {

        $startingDate = $this->start;
        $endingDate = $this->end;

        if ($this->oneDate != null) {

            $startingDate->setDate(
                $this->oneDate->format('Y'),
                $this->oneDate->format('m'),
                $this->oneDate->format('d')
            );

            $endingDate->setDate(
                $this->oneDate->format('Y'),
                $this->oneDate->format('m'),
                $this->oneDate->format('d')
            );
        }

        if ($this->startingDate != null) {

            $startingDate->setDate(
                $this->startingDate->format('Y'),
                $this->startingDate->format('m'),
                $this->startingDate->format('d')
            );
        }

        if ($this->startingTime != null) {
            $startingDate->setTime($this->startingTime->format('H'), $this->startingTime->format('i'));
        }

        if ($this->endingTime != null) {
            $endingDate->setDate(
                $this->endingTime->format('Y'),
                $this->endingTime->format('m'),
                $this->endingTime->format('d')
            );
        }

        if ($this->endingTime != null) {
            $endingDate->setTime($this->endingTime->format('H'), $this->endingTime->format('i'));
        }

        $this->start = $startingDate;
        $this->end = $endingDate;

    }

    /**
     * @return mixed
     */
    public function getStartingTime()
    {
        return $this->startingTime;
    }

    /**
     * @param mixed $startingTime
     */
    public function setStartingTime($startingTime)
    {
        $this->startingTime = $startingTime;

        //$this->start->setTime($this->startingTime->format('H'), $this->startingTime->format('i'));

    }

    /**
     * @return mixed
     */
    public function getEndingTime()
    {
        return $this->endingTime;
    }

    /**
     * @param mixed $endingDate
     */
    public function setEndingTime($endingDate)
    {
        $this->endingTime = $endingDate;

        //$this->end->setTime($this->endingTime->format('H'), $this->endingTime->format('i'));
    }

    /**
     * @return mixed
     */
    public function getOneDate()
    {
        return $this->oneDate;
    }

    /**
     * @param mixed $oneDate
     */
    public function setOneDate($oneDate)
    {
        $this->oneDate = $oneDate;
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
     * Set start
     *
     * @param \DateTime $start
     * @return Date
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Date
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set event
     *
     * @param \gospelcenter\EventBundle\Entity\Event $event
     * @return Date
     */
    public function setEvent(\gospelcenter\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \gospelcenter\EventBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set celebration
     *
     * @param \gospelcenter\CelebrationBundle\Entity\Celebration $celebration
     * @return Date
     */
    public function setCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebration = null)
    {
        $this->celebration = $celebration;

        return $this;
    }

    /**
     * Get celebration
     *
     * @return \gospelcenter\CelebrationBundle\Entity\Celebration
     */
    public function getCelebration()
    {
        return $this->celebration;
    }


}