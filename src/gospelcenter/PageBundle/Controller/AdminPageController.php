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
use gospelcenter\PageBundle\Form\PageAddType;

// Center
use gospelcenter\CenterBundle\Entity\Center;


class AdminPageController extends Controller {
    
    /*
     *   List of all pages
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findAllByCenter($center);
        
        return $this->render('gospelcenterPageBundle:AdminPage:list.html.twig', array(
            'center' => $center,
            'pages' => $pages,
            'page' => 'pages',
            'tab' => 'pages'
        ));
    }
    
    
    /*
     *   Add a page
     */
    public function addAction(Center $center)
    {
        $page = new Page($center);
        $form = $this->createForm(new PageAddType($center), $page);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The page has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }
    
    
    /*
     *   Edit a page
     *   @param $page = Page
     *          $center = Center
     */
    public function editAction(Center $center, Page $page)
    {   
        $form = $this->createForm(new PageType($center), $page);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The page has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:edit.html.twig', array(
            'center' => $center,
            'objPage' => $page,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
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