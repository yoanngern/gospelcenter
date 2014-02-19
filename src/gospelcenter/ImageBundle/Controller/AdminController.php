<?php

namespace gospelcenter\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Image
use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\ImageBundle\Form\ImageType;


class AdminController extends Controller {
    
    /*
     *   List of images
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllByCenter($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterImageBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'images' => $images,
                'page' => 'images',
                'tab' => 'images'
            ));
        }
        
        return $this->render('gospelcenterImageBundle:Admin:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'images',
            'tab' => 'images'
        ));
    }
    
    
    /*
     *   List of all images
     */
    public function allAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAll();
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterImageBundle:AdminMobile:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'images',
            'tab' => 'imagesAll'
        ));
        }
        
        return $this->render('gospelcenterImageBundle:Admin:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'images',
            'tab' => 'imagesAll'
        ));
    }
    
    
    /*
     *   Add a location
     */
    public function addAction(Center $center)
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
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_images', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterImageBundle:AdminMobile:add.html.twig', array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'images'
            ));
        }
        
        return $this->render('gospelcenterImageBundle:Admin:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'images'
        ));
    }
    
    
    /*
     *   Edit a location
     *   @param $image = Image
     *          $center = Center
     */
    public function editAction(Center $center, Image $image)
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
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_images', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()) {
            return $this->render('gospelcenterImageBundle:AdminMobile:edit.html.twig', array(
                'center' => $center,
                'image' => $image,
                'form' => $form->createView(),
                'page' => 'images'
            ));
        }
        
        return $this->render('gospelcenterImageBundle:Admin:edit.html.twig', array(
            'center' => $center,
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