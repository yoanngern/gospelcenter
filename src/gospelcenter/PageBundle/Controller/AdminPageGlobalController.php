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
use gospelcenter\PageBundle\Form\PageGlobalType;
use gospelcenter\PageBundle\Form\PageGlobalAddType;


class AdminPageGlobalController extends Controller {
    
    /*
     *   List of global pages
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findAllGlobal();
        
        return $this->render('gospelcenterPageBundle:AdminPageGlobal:list.html.twig', array(
            'pages' => $pages,
            'page' => 'pages',
            'tab' => 'pages'
        ));
    }
    
    
    /*
     *   Add a global page
     */
    public function addAction()
    {
        $page = new Page();
        $form = $this->createForm(new PageGlobalAddType, $page);
        
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
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_pages'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPageGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }
    
    
    /*
     *   Edit a global page
     *   @param $page = Page
     */
    public function editAction(Page $page)
    {   
        $form = $this->createForm(new PageGlobalType, $page);
        
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
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_pages'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPageGlobal:edit.html.twig', array(
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