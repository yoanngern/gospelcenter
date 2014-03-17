<?php

namespace gospelcenter\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Event
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\EventBundle\Form\EventType;

// Image
use gospelcenter\ImageBundle\Entity\Image;

// Location
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\LocationBundle\Form\LocationType;

// Center
use gospelcenter\CenterBundle\Entity\Center;


class AdminController extends Controller {
    
    /*
     *   List of all locations
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $locations = $em->getRepository('gospelcenterLocationBundle:Location')->findAllByCenter($center);

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterLocationBundle:AdminMobile:list.html.twig', array(
                'center' => $center,
                'locations' => $locations,
                'page' => 'locations'
            ));
        }
        
        return $this->render('gospelcenterLocationBundle:Admin:list.html.twig', array(
            'center' => $center,
            'locations' => $locations,
            'page' => 'locations'
        ));
    }
    
    
    /*
     *   Add a location
     */
    public function addAction(Center $center)
    {
        $location = new Location();
        $form = $this->createForm(new LocationType, $location);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($location);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The location has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_locations', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterLocationBundle:AdminMobile:add.html.twig', array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'locations'
            ));
        }
        
        return $this->render('gospelcenterLocationBundle:Admin:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'locations'
        ));
    }
    
    
    /*
     *   Edit a location
     *   @param $location = Location
     *          $center = Center
     */
    public function editAction(Center $center, Location $location)
    {   
        $form = $this->createForm(new LocationType, $location);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($location);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The location has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_locations', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterLocationBundle:AdminMobile:edit.html.twig', array(
                'center' => $center,
                'location' => $location,
                'form' => $form->createView(),
                'page' => 'locations'
            ));
        }
        
        return $this->render('gospelcenterLocationBundle:Admin:edit.html.twig', array(
            'center' => $center,
            'location' => $location,
            'form' => $form->createView(),
            'page' => 'locations'
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