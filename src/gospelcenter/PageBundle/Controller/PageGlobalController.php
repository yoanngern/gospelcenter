<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Page
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageType;


class PageGlobalController extends Controller
{
    public function indexAction($page = 'home')
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('gospelcenterPageBundle:Page')->findAGlobalPage($page);
        
        if (!$page) {
            throw $this->createNotFoundException('This page doesn\'t exist');
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterPageBundle:Mobile:index.html.twig', array(
                'page' => $page->getRef(),
                'article' => $page
            )); 
        }
        
        return $this->render('gospelcenterPageBundle:PageGlobal:index.html.twig', array(
            'page' => $page->getRef(),
            'article' => $page
        ));
    }
}
