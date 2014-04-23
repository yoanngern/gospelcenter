<?php

namespace gospelcenter\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Event
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\EventBundle\Form\EventType;

// Image
use gospelcenter\ImageBundle\Entity\Image;

// Location
use gospelcenter\LocationBundle\Entity\Location;

// Center
use gospelcenter\CenterBundle\Entity\Center;


class AdminController extends Controller {
    
    /*
     * List of next events
     * @param $center = Center
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findNextByCenterWithHidden($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterEventBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'events' => $events,
                'page' => 'events'
            ));
        }
        
        return $this->render('gospelcenterEventBundle:Admin:list.html.twig', array(
            'center' => $center,
            'events' => $events,
            'page' => 'events',
            'tab' => 'nextEvents'
        ));
    }
    
    
    /*
     * List of past events
     * @param $center = Center
     */
    public function pastAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findPastByCenterWithHidden($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterEventBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'events' => $events,
                'page' => 'events'
            ));
        }
        
        return $this->render('gospelcenterEventBundle:Admin:list.html.twig', array(
            'center' => $center,
            'events' => $events,
            'page' => 'events',
            'tab' => 'pastEvents'
        ));
    }
    
    
    /*
     *   Add an event
     */
    public function addAction(Center $center)
    {
        $event = new Event($center);
        $form = $this->createForm(new EventType, $event);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                $event->addCenter($center);
                
                $em->persist($event);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The event has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_events', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterEventBundle:AdminMobile:add.html.twig', array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'events'
            ));
        }
        
        return $this->render('gospelcenterEventBundle:Admin:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'events'
        ));
    }
    
    
    /*
     *   Edit an event
     *   @param $event = Event
     *          $center = Center
     */
    public function editAction(Center $center, Event $event)
    {   
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
                
                $this->get('session')->getFlashBag()->add('info', 'The event has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_events', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterEventBundle:AdminMobile:edit.html.twig', array(
                'center' => $center,
                'event' => $event,
                'form' => $form->createView(),
                'page' => 'events'
            ));
        }
        
        return $this->render('gospelcenterEventBundle:Admin:edit.html.twig', array(
            'center' => $center,
            'event' => $event,
            'form' => $form->createView(),
            'page' => 'events'
        ));
    }
    
    
    /*
    *   Publish event
    */
    public function publishAction(Center $center, Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        
        $event = $em->getRepository('gospelcenterEventBundle:Event')->findWithAll($event, $center);
        
        return $this->redirect( $this->generateUrl('gospelcenterAdmin_events', array(
            'center' => $center->getRef()
        )));
    }
    
    
    /*
     *   Delete a event
     */
    public function deleteAction(Center $center, Event $event)
    {   
        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($event);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'Event deleted.');
        
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_events', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterEventBundle:Admin:delete.html.twig', array(
              'center' => $center,
              'event' => $event,
              'form'    => $form->createView(),
              'page' => 'events'
        ));
    }

}