<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Event
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\EventBundle\Form\EventType;

// Image
use gospelcenter\ImageBundle\Entity\Image;

// Page
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageType;

// Slide
use gospelcenter\PageBundle\Entity\Slide;
use gospelcenter\PageBundle\Form\SlideType;
use gospelcenter\CenterBundle\Entity\Center;


class AdminSlideGlobalController extends Controller {
    
    /*
     *   List of global slides
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $slides = $em->getRepository('gospelcenterPageBundle:Slide')->findAllGlobal();
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:list.html.twig', array(
            'slides' => $slides,
            'page' => 'pages',
            'tab' => 'slides'
        ));
    }
    
    
    /*
     *   Add a global slide
     */
    public function addAction()
    {
        $slide = new Slide();
        $form = $this->createForm(new SlideType, $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_slides'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'pages'
        ));
    }
    
    
    /*
     *   Edit a global slide
     *   @param $slide = Slide
     */
    public function editAction(Slide $slide)
    {   
        $form = $this->createForm(new SlideType, $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_slides'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:edit.html.twig', array(
            'slide' => $slide,
            'form' => $form->createView(),
            'page' => 'pages'
        ));
    }
    
    
    /*
     *   Delete a location
     */
    public function deleteAction(Center $center, Location $location)
    {      
        return $this->redirect( $this->generateUrl('gospelcenterAdmin_locations', array(
            'center' => $center->getRef()
        )));
    }
    
    
    /*
     *   Get JSON location
     *   @param $location = location id
     *          $center = Center
     */
    public function singleJSONAction(Center $center, $location)
    {   
        
        $em = $this->getDoctrine()->getManager();
        
        $location = $em->getRepository('gospelcenterLocationBundle:Location')->findOne($location);
        
        $response = new Response(json_encode($location));
        
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}