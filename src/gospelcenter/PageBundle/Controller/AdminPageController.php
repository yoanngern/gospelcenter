<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageAddType;
use gospelcenter\PageBundle\Form\PageType;
use gospelcenter\PageBundle\Form\YouthPageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
     *   Delete a page
     */
    public function deleteAction(Center $center, Page $page)
    {   
        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'Page deleted.');
        
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:delete.html.twig', array(
              'center' => $center,
              'objPage' => $page,
              'form'    => $form->createView(),
              'page' => 'pages'
        ));
    }
    
    
    /*
     *   List of all youth pages
     */
    public function youthAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthByCenter($center);
        
        return $this->render('gospelcenterPageBundle:AdminPage:youth.html.twig', array(
            'center' => $center,
            'pages' => $pages,
            'page' => 'pages',
            'tab' => 'youth'
        ));
    }
    
    
    /*
     *   Edit a youth page
     *   @param $page = Page
     *          $center = Center
     */
    public function youthEditAction(Center $center, Page $page)
    {   
        $form = $this->createForm(new YouthPageType($center), $page);
        
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
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_youth', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:youthEdit.html.twig', array(
            'center' => $center,
            'objPage' => $page,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }
}