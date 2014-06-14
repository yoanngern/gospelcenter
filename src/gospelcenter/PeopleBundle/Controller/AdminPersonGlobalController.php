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
use gospelcenter\PeopleBundle\Form\PersonGlobalWithAccountType;
use gospelcenter\PeopleBundle\Form\PersonGlobalType;

// Member
use gospelcenter\CenterBundle\Entity\Member;
use gospelcenter\CenterBundle\Form\MemberType;

// Visitor
use gospelcenter\CenterBundle\Entity\Visitor;
use gospelcenter\CenterBundle\Form\VisitorType;


class AdminPersonGlobalController extends Controller {
    
    /*
     *   List of all persons
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $persons = $em->getRepository('gospelcenterPeopleBundle:Person')->findAll();
        
        return $this->render('gospelcenterPeopleBundle:AdminPersonGlobal:list.html.twig', array(
            'persons' => $persons,
            'page' => 'people',
            'tab' => 'contacts'
        ));
    }
    
    
    /*
    *   Add a person
    */
    public function addAction()
    {
        
        $session = $this->get('session');
        
        $person = new Person();
        $form = $this->createForm(new PersonGlobalType, $person);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            if($session->get('previousUrl') != null) {
                $previousUrl = $session->get('previousUrl');
            } else {
                $previousUrl = $this->generateUrl('gospelcenterAdminGlobal_persons');
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
                
                return $this->redirect($previousUrl);
            }
        }
        
        $previousUrl = $this->get('request')->server->get('HTTP_REFERER');
        
        $session->set('previousUrl', $previousUrl);
        
        return $this->render('gospelcenterPeopleBundle:AdminPersonGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'people',
            'person' => $person
        ));
    }
    
    /*
    *   Edit a person
    */
    public function editAction(Person $person)
    {
        $session = $this->get('session');
        
        if($person->getUser()) {
            $form = $this->createForm(new PersonGlobalWithAccountType, $person);
        } else {
            $form = $this->createForm(new PersonGlobalType, $person);
        }
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            
            if($session->get('previousUrl') != null) {
                $previousUrl = $session->get('previousUrl');
            } else {
                $previousUrl = $this->generateUrl('gospelcenterAdminGlobal_persons');
            }
            
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();
                
                return $this->redirect($previousUrl);
            }
        }
        
        $previousUrl = $this->get('request')->server->get('HTTP_REFERER');
        
        $session->set('previousUrl', $previousUrl);
        
        return $this->render('gospelcenterPeopleBundle:AdminPersonGlobal:edit.html.twig', array(
            'person' => $person,
            'form' => $form->createView(),
            'page' => 'people'
        ));
    }    
}