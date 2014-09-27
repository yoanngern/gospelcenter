<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageGlobalController extends Controller
{
    /**
     * @param string $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
        
        return $this->render('gospelcenterPageBundle:PageGlobal:index.html.twig', array(
            'page' => $page->getRef(),
            'article' => $page,
            'centers' => $centers
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        
        return $this->render('gospelcenterPageBundle:PageGlobal:home.html.twig', array(
            'page' => 'home'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function godAction()
    {
        
        return $this->render('gospelcenterPageBundle:PageGlobal:god.html.twig', array(
            'page' => 'god'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tvAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $starsVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findStarVideo(4);

        return $this->render('gospelcenterPageBundle:PageGlobal:tv.html.twig', array(
            'starsVideos' => $starsVideos,
            'page' => 'television'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        
        return $this->render('gospelcenterPageBundle:PageGlobal:contact.html.twig', array(
            'page' => 'contact'
        ));
    }
}
