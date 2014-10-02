<?php

namespace gospelcenter\EventBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\EventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller {

    /**
     * Draw the list of all next events
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {    
        $em = $this->getDoctrine()->getManager();
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findUpcoming($center);

        $dates = $em->getRepository('gospelcenterDateBundle:Date')->findNext($center);
        
        return $this->render('gospelcenterEventBundle:Event:list.html.twig', array(
            'events' => $events,
            'dates' => $dates,
            'center' => $center,
            'page' => 'events',
            'tab' => 'events'
        ));   
    }

    /**
     * Draw the Event received in parameter
     * @param Center $center
     * @param Event $event
     * @return Response
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

}