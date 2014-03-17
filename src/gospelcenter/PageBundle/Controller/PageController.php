<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Page
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageType;

// Center
use gospelcenter\CenterBundle\Entity\Center;

class PageController extends Controller
{
    public function indexAction(Center $center, $page = 'home')
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('gospelcenterPageBundle:Page')->findAPage($center, $page);
        
        if (!$page) {
            throw $this->createNotFoundException('This page doesn\'t exist');
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:Mobile:index.html.twig', array(
                'center' => $center,
                'page' => $page->getRef(),
                'article' => $page
            )); 
        }
        
        return $this->render('gospelcenterPageBundle:Page:index.html.twig', array(
            'center' => $center,
            'page' => $page->getRef(),
            'article' => $page
        ));
    }
    
    public function homeAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findNext($center, 2);
        
        $events = $em->getRepository('gospelcenterEventBundle:Event')->findNext($center, 2);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:Mobile:home.html.twig', array(
                'center' => $center,
                'page' => 'home'
            ));
        }
        
        return $this->render('gospelcenterPageBundle:Page:home.html.twig', array(
            'center' => $center,
            'celebrations' => $celebrations,
            'events' => $events,
            'page' => 'home'
        ));
    }
    
    public function aboutAction(Center $center)
    {
        
        $language = 'fr';
        
        return $this->render('gospelcenterPageBundle::staticPage.html.twig', array(
            'center' => $center,
            'language' => $language,
            'template' => 'about',
            'page' => 'about'
        ));
    }
    
    public function leadershipAction(Center $center)
    {
        
        $language = 'fr';
        
        return $this->render('gospelcenterPageBundle::staticPage.html.twig', array(
            'center' => $center,
            'language' => $language,
            'template' => 'leadership',
            'page' => 'about'
        ));
    }
    
    public function staffAction(Center $center)
    {
        
        $language = 'fr';
        
        return $this->render('gospelcenterPageBundle::staticPage.html.twig', array(
            'center' => $center,
            'language' => $language,
            'template' => 'staff',
            'page' => 'about'
        ));
    }
    
    public function musicAction(Center $center)
    {
        
        $language = 'fr';
        
        return $this->render('gospelcenterPageBundle::staticPage.html.twig', array(
            'center' => $center,
            'language' => $language,
            'template' => 'music',
            'page' => 'about'
        ));
    }
}
