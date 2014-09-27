<?php

namespace gospelcenter\PeopleBundle\Controller;

use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\PeopleBundle\Form\PersonGlobalType;
use gospelcenter\PeopleBundle\Form\PersonGlobalWithAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminPersonGlobalController extends Controller {


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $persons = $em->getRepository('gospelcenterPeopleBundle:Person')->findAllGlobal();
        
        return $this->render('gospelcenterPeopleBundle:AdminPersonGlobal:list.html.twig', array(
            'persons' => $persons,
            'page' => 'people',
            'tab' => 'contacts'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
            
            //$firstname = $person->getFirstname();
            //$lastname = $person->getLastname();
            
            //$imageTitle = $firstname. " " .$lastname;
            //$imageType = "person";
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The person has been added.');
                
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


    /**
     * @param Person $person
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
                
                $this->get('session')->getFlashBag()->add('info', 'The person has been edited.');
                
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