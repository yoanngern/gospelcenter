<?php

namespace gospelcenter\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;

// Image
use gospelcenter\ImageBundle\Entity\Image;

// Location
use gospelcenter\LocationBundle\Entity\Location;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Speaker
use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CelebrationBundle\Form\SpeakerType;

// People
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\PeopleBundle\Form\PersonType;

// Member
use gospelcenter\CenterBundle\Entity\Member;
use gospelcenter\CenterBundle\Form\MemberType;

// Visitor
use gospelcenter\CenterBundle\Entity\Visitor;
use gospelcenter\CenterBundle\Form\VisitorType;


class AdminPersonController extends Controller {
    
    /*
     *   List of person
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $persons = $em->getRepository('gospelcenterPeopleBundle:Person')->findAllByCenter($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterPeopleBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'persons' => $persons,
                'page' => 'people',
                'tab' => 'contacts'
            ));
        }
        
        return $this->render('gospelcenterPeopleBundle:AdminPerson:list.html.twig', array(
            'center' => $center,
            'persons' => $persons,
            'page' => 'people',
            'tab' => 'contacts'
        ));
    }
    
    
    /*
     *   List of all persons
     */
    public function allAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $persons = $em->getRepository('gospelcenterPeopleBundle:Person')->findAllOrder();
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterPeopleBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'persons' => $persons,
                'page' => 'people',
                'tab' => 'contactsAll'
            ));
        }
        
        return $this->render('gospelcenterPeopleBundle:AdminPerson:list.html.twig', array(
            'center' => $center,
            'persons' => $persons,
            'page' => 'people',
            'tab' => 'contactsAll'
        ));
    }
    
    
    /*
    *   Add a person
    */
    public function addAction(Center $center)
    {
        
        $session = $this->get('session');
        
        $person = new Person();
        $form = $this->createForm(new PersonType, $person);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            if($session->get('previousUrl') != null) {
                $previousUrl = $session->get('previousUrl');
            } else {
                $previousUrl = $this->generateUrl('gospelcenterAdmin_persons', array(
                                    'center' => $center->getRef()
                                ));
            }
            
            $form->bind($request);
            
            $firstname = $person->getFirstname();
            $lastname = $person->getLastname();
            
            $imageTitle = $firstname. " " .$lastname;
            $imageType = "person";
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();
                
                
                // If the person is a Speaker
                if($person->getIsSpeaker() == 1) {
                    $speaker = new Speaker();
                    $speaker->setPerson($person);
                    
                    $em->persist($speaker);
                    $em->flush();
                }
                
                
                // If the person is a Visitor
                if($person->getIsVisitor() == 1) {
                    $visitor = new Visitor();
                    $visitor->setPerson($person);
                    $visitor->addCenter($center);
                    
                    $em->persist($center);
                    $em->persist($visitor);
                    $em->flush();
                }
                
                // If the person is a Member
                if($person->getIsMember() == 1) {
                    $member = new Member();
                    $member->setPerson($person);
                    $member->addCenter($center);
                    
                    $em->persist($member);
                    $em->flush();
                }
                
                
                $this->get('session')->getFlashBag()->add('info', 'The contact has been added.');
                
                return $this->redirect($previousUrl);
            }
        }
        
        $previousUrl = $this->get('request')->server->get('HTTP_REFERER');
        
        $session->set('previousUrl', $previousUrl);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterPeopleBundle:AdminMobile:add.html.twig', array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'people',
                'person' => $person
            ));
        }
        
        return $this->render('gospelcenterPeopleBundle:AdminPerson:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'people',
            'person' => $person
        ));
    }
    
    /*
    *   Edit a person
    */
    public function editAction(Center $center, Person $person)
    {
        $session = $this->get('session');
        
        if($person->getSpeaker() != null) {
            $person->setIsSpeaker(true);
        }
        
        if($person->getVisitor() != null) {
            $person->setIsVisitor(true);
        }
        
        if($person->getMember() != null) {
            $person->setIsMember(true);
        }
        
        $form = $this->createForm(new PersonType, $person);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            
            if($session->get('previousUrl') != null) {
                $previousUrl = $session->get('previousUrl');
            } else {
                $previousUrl = $this->generateUrl('gospelcenterAdmin_persons', array(
                                    'center' => $center->getRef()
                                ));
            }
            
            $form->bind($request);
            
            if($form->isValid())
            {
                // If the person was a speaker
                if($person->getSpeaker() != null) {
                    $wasSpeaker = true;
                } else {
                    $wasSpeaker = false;
                }
                
                // If the person was a member
                if($person->getMember() != null) {
                    $wasMember = true;
                } else {
                    $wasMember = false;
                }
                
                // If the person was a visitor
                if($person->getVisitor() != null) {
                    $wasVisitor = true;
                } else {
                    $wasVisitor = false;
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();
                
                
                // If the person is a Speaker
                if($person->getIsSpeaker() && !$wasSpeaker) {
                    $speaker = new Speaker();
                    $speaker->setPerson($person);
                    
                    $em->persist($speaker);
                    $em->flush();
                } elseif(!$person->getIsSpeaker() && $wasSpeaker) {
                    $speaker = $person->getSpeaker();
                    $em->remove($speaker);
                    $em->flush();
                }
                
                
                // If the person is a Member
                if($person->getIsMember() && !$wasMember) {
                    $member = new Member();
                    $member->setPerson($person);
                    $member->addCenter($center);
                    
                    $em->persist($member);
                    $em->flush();
                } elseif(!$person->getIsMember() && $wasMember) {
                    $member = $person->getMember();
                    $em->remove($member);
                    $em->flush();
                }
                
                // If the person is a Visitor
                if($person->getIsVisitor() && !$wasVisitor) {
                    $visitor = new Visitor();
                    $visitor->setPerson($person);
                    $visitor->addCenter($center);
                    
                    $em->persist($visitor);
                    $em->flush();
                } elseif(!$person->getIsVisitor() && $wasVisitor) {
                    $visitor = $person->getVisitor();
                    $em->remove($visitor);
                    $em->flush();
                }
                
                $this->get('session')->getFlashBag()->add('info', 'The contact has been edited.');
                
                return $this->redirect($previousUrl);
            }
        }
        
        $previousUrl = $this->get('request')->server->get('HTTP_REFERER');
        
        $session->set('previousUrl', $previousUrl);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterPeopleBundle:AdminMobile:edit.html.twig', array(
                'center' => $center,
                'person' => $person,
                'form' => $form->createView(),
                'page' => 'people'
            ));
        }
        
        return $this->render('gospelcenterPeopleBundle:AdminPerson:edit.html.twig', array(
            'center' => $center,
            'person' => $person,
            'form' => $form->createView(),
            'page' => 'people'
        ));
    }    
}