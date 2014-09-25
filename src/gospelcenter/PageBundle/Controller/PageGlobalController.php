<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageGlobalController extends Controller
{
    public function indexAction($page = 'home')
    {
        $em = $this->getDoctrine()->getManager();
        
        if($page == 'celebrations') {
            $centers = $em->getRepository('gospelcenterCenterBundle:Center')->findAll();
        } else {
            $centers = null;
        }
        
        $page = $em->getRepository('gospelcenterPageBundle:Page')->findAGlobalPage($page);
        
        if (!$page) {
            throw $this->createNotFoundException('This page doesn\'t exist');
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:MobileGlobal:index.html.twig', array(
                'page' => $page->getRef(),
                'article' => $page,
                'centers' => $centers
            )); 
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:index.html.twig', array(
            'page' => $page->getRef(),
            'article' => $page,
            'centers' => $centers
        ));
    }
    
    /**
     *  Home page
     *
     */
    public function homeAction()
    {
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:MobileGlobal:home.html.twig', array(
                'page' => 'home'
            ));
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:home.html.twig', array(
            'page' => 'home'
        ));
    }
    
    
    /**
     *  God page
     *
     */
    public function godAction()
    {
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:MobileGlobal:god.html.twig', array(
                'page' => 'god'
            ));
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:god.html.twig', array(
            'page' => 'god'
        ));
    }
    
    
    /**
     *  TV page
     *
     */
    public function tvAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $starsVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findStarVideo(4);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:MobileGlobal:tv.html.twig', array(
                'starsVideos' => $starsVideos,
                'page' => 'television'
            ));
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:tv.html.twig', array(
            'starsVideos' => $starsVideos,
            'page' => 'television'
        ));
    }
    
    
    /**
     *  Contact page
     *
     */
    public function contactAction()
    {
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:MobileGlobal:contact.html.twig', array(
                'page' => 'contact'
            ));
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:contact.html.twig', array(
            'page' => 'contact'
        ));
    }
}
