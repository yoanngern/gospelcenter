<?php

namespace gospelcenter\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\EventBundle\Form\EventType;

class EventController extends Controller {
    
   /*
    *   Draw the list of all next events
    *
    */
    public function listAction(Center $center)
    {    
        $em = $this->getDoctrine()->getManager();
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findUpcoming($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterEventBundle:Mobile:list.html.twig', array(
                'events' => $events,
                'center' => $center,
                'page' => 'events'
            ));   
        }
        
        return $this->render('gospelcenterEventBundle:Event:list.html.twig', array(
            'events' => $events,
            'center' => $center,
            'page' => 'events'
        ));   
    }
    
    
   /*
    *   Draw the Event received in parameter
    *   @param the id of the event
    */
    public function eventAction(Center $center, Event $event)
    {    
        $em = $this->getDoctrine()->getManager();
        
        $event = $em->getRepository('gospelcenterEventBundle:Event')->findWithAll($event, $center);
        
        return $this->render('gospelcenterEventBundle:Event:event.html.twig', array(
            'event' => $event,
            'center' => $center,
            'page' => 'events'
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
    *   Remove the event received in parameter
    *   @param the id of the event
    */
    public function deleteAction(Center $center, Event $event)
    {
        return $this->render('gospelcenterEventBundle:Event:delete.html.twig', array(
            'event' => $event,
            'center' => $center,
            'page' => 'events'
        ));
    }
    
    
   /*
    *   Get next events
    *   @param the number of event
    *   @return next events in JSON
    */
    public function jsonAction(Center $center, $nb)
    {   
        $em = $this->getDoctrine()->getManager();
        
        $request = $this->getRequest();
        
        $start = $request->query->get('start');
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findAllByCenter($center, $nb, $start);
        
        $response = new Response(json_encode($events));
        
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
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