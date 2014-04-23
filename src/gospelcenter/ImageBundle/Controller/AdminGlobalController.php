<?php

namespace gospelcenter\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Image
use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\ImageBundle\Form\ImageType;


class AdminGlobalController extends Controller {
    
    /*
     *   List of all images
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllOrder();
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:list.html.twig', array(
            'images' => $images,
            'page' => 'images'
        ));
    }
    
    
    /*
     *   Add an image
     */
    public function addAction()
    {
        $image = new Image();
        $form = $this->createForm(new ImageType, $image);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The image has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_images'));
            }
        }
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'images'
        ));
    }
    
    
    /*
     *   Edit an image
     *   @param $image = Image
     */
    public function editAction(Image $image)
    {   
        $form = $this->createForm(new ImageType, $image);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The image has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_images'));
            }
        }
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:edit.html.twig', array(
            'image' => $image,
            'form' => $form->createView(),
            'page' => 'images'
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
}