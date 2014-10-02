<?php

namespace gospelcenter\CelebrationBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\EventBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CelebrationController extends Controller {


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
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
    
}