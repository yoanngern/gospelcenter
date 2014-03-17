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

// Page
use gospelcenter\PageBundle\Entity\Slide;
use gospelcenter\PageBundle\Form\SlideType;

// Center
use gospelcenter\CenterBundle\Entity\Center;


class AdminSlideController extends Controller {
    
    /*
     *   List of slides
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $slides = $em->getRepository('gospelcenterPageBundle:Slide')->findAllByCenter($center);
        
        return $this->render('gospelcenterPageBundle:AdminSlide:list.html.twig', array(
            'center' => $center,
            'slides' => $slides,
            'page' => 'pages',
            'tab' => 'slides'
        ));
    }
    
    
    /*
     *   Add a slide
     */
    public function addAction(Center $center)
    {
        $slide = new Slide($center);
        $form = $this->createForm(new SlideType($center), $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The slide has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_slides', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlide:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'pages'
        ));
    }
    
    
    /*
     *   Edit a slide
     *   @param $slide = Slide
     *          $center = Center
     */
    public function editAction(Center $center, Slide $slide)
    {   
        $form = $this->createForm(new SlideType($center), $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The slide has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_slides', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlide:edit.html.twig', array(
            'center' => $center,
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