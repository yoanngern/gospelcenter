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
        
        return $this->render('gospelcenterPageBundle:Page:home.html.twig', array(
            'center' => $center,
            'page' => 'home'
        ));
    }
}
