<?php

namespace gospelcenter\CelebrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Celebration
use gospelcenter\CelebrationBundle\Entity\Celebration;
use gospelcenter\CelebrationBundle\Form\CelebrationType;
use gospelcenter\CelebrationBundle\Form\CelebrationMobileType;

// Entity
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\CelebrationBundle\Entity\Tag;

class CelebrationController extends Controller {
    
   /*
    *   Next celebrations
    *
    */
    public function listAction(Center $center)
    {    
        $em = $this->getDoctrine()->getManager();
        
        $nextCelebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findNext($center, 4);
        $lastCelebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findLast($center, 3);
        
        return $this->render('gospelcenterCelebrationBundle:Celebration:list.html.twig', array(
            'nextCelebrations' => $nextCelebrations,
            'lastCelebrations' => $lastCelebrations,
            'center' => $center,
            'page' => 'celebrations'
        ));
    }
    
    
   /*
    *   Add a new event
    *
    */
    public function addAction(Center $center)
    {    
        
        $event = new Event();
        $event->setStartingDate(new \Datetime());
        $event->setEndingDate(new \Datetime());
        $form = $this->createForm(new EventType, $event);
                     
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterEvents_event', array(
                    'id' => $event->getId(),
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterEventBundle:Event:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'events'
        ));   
    }
    
    
   /*
    *   Edit the event received in parameter
    *   @param the id of the event
    */
    public function editAction(Center $center, Event $event)
    {    
        $em = $this->getDoctrine()->getManager();
        
        $event = $em->getRepository('gospelcenterEventBundle:Event')->findWithAll($event, $center);
        
        return $this->render('gospelcenterEventBundle:Event:edit.html.twig', array(
            'event' => $event,
            'center' => $center,
            'page' => 'events'
        ));   
    }
    
    
   /*
    *   Get next star events
    *   @param the number of star event
    *   @return next star events in HTML
    */
    public function starEventsAction(Center $center, $nb)
    {   
        $list = array(
            array('id' => 2, 'title' => 'Prayer Impact'),
            array('id' => 5, 'title' => 'Weekend des leaders')
        );
        
        return $this->render('gospelcenterEventBundle:Event:starEvents.html.twig', array(
            'event_list' => $list,
            'center' => $center,
            'page' => 'events'
        ));   
    }
    
}