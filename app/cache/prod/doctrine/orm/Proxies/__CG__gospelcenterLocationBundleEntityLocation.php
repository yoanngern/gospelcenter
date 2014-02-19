<?php

namespace Proxies\__CG__\gospelcenter\LocationBundle\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Location extends \gospelcenter\LocationBundle\Entity\Location implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function __toString()
    {
        $this->__load();
        return parent::__toString();
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setName($name)
    {
        $this->__load();
        return parent::setName($name);
    }

    public function getName()
    {
        $this->__load();
        return parent::getName();
    }

    public function setAddress1($address1)
    {
        $this->__load();
        return parent::setAddress1($address1);
    }

    public function getAddress1()
    {
        $this->__load();
        return parent::getAddress1();
    }

    public function setAddress2($address2)
    {
        $this->__load();
        return parent::setAddress2($address2);
    }

    public function getAddress2()
    {
        $this->__load();
        return parent::getAddress2();
    }

    public function setPostalCode($postalCode)
    {
        $this->__load();
        return parent::setPostalCode($postalCode);
    }

    public function getPostalCode()
    {
        $this->__load();
        return parent::getPostalCode();
    }

    public function setCity($city)
    {
        $this->__load();
        return parent::setCity($city);
    }

    public function getCity()
    {
        $this->__load();
        return parent::getCity();
    }

    public function setCountry($country)
    {
        $this->__load();
        return parent::setCountry($country);
    }

    public function getCountry()
    {
        $this->__load();
        return parent::getCountry();
    }

    public function setLatitude($latitude)
    {
        $this->__load();
        return parent::setLatitude($latitude);
    }

    public function getLatitude()
    {
        $this->__load();
        return parent::getLatitude();
    }

    public function setLongitude($longitude)
    {
        $this->__load();
        return parent::setLongitude($longitude);
    }

    public function getLongitude()
    {
        $this->__load();
        return parent::getLongitude();
    }

    public function addCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->__load();
        return parent::addCenter($centers);
    }

    public function removeCenter(\gospelcenter\CenterBundle\Entity\Center $centers)
    {
        $this->__load();
        return parent::removeCenter($centers);
    }

    public function getCenters()
    {
        $this->__load();
        return parent::getCenters();
    }

    public function addCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebrations)
    {
        $this->__load();
        return parent::addCelebration($celebrations);
    }

    public function removeCelebration(\gospelcenter\CelebrationBundle\Entity\Celebration $celebrations)
    {
        $this->__load();
        return parent::removeCelebration($celebrations);
    }

    public function getCelebrations()
    {
        $this->__load();
        return parent::getCelebrations();
    }

    public function addEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->__load();
        return parent::addEvent($events);
    }

    public function removeEvent(\gospelcenter\EventBundle\Entity\Event $events)
    {
        $this->__load();
        return parent::removeEvent($events);
    }

    public function getEvents()
    {
        $this->__load();
        return parent::getEvents();
    }

    public function addBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->__load();
        return parent::addBase($bases);
    }

    public function removeBase(\gospelcenter\CenterBundle\Entity\Base $bases)
    {
        $this->__load();
        return parent::removeBase($bases);
    }

    public function getBases()
    {
        $this->__load();
        return parent::getBases();
    }

    public function addPerson(\gospelcenter\PeopleBundle\Entity\Person $persons)
    {
        $this->__load();
        return parent::addPerson($persons);
    }

    public function removePerson(\gospelcenter\PeopleBundle\Entity\Person $persons)
    {
        $this->__load();
        return parent::removePerson($persons);
    }

    public function getPersons()
    {
        $this->__load();
        return parent::getPersons();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'address1', 'address2', 'postalCode', 'city', 'country', 'latitude', 'longitude', 'centers', 'celebrations', 'events', 'bases', 'persons');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}