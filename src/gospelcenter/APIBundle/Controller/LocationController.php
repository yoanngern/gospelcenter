<?php

namespace gospelcenter\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    
    /**
     *  GET - list all locations
     */
    public function getLocationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        
        $centerId = $request->query->get('center');
        $center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);
        
        $locations = $em->getRepository('gospelcenterLocationBundle:Location')->findAllJSON();
        
        $response = new Response(json_encode($locations));
        
        $response->headers->set('Content-Type', 'application/json');    
        
        return $response;
    }
    
    
    /**
     *  GET - get location details
     */
    public function getLocationAction($location)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        
        $centerId = $request->query->get('center');
        $center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);
        
        $location = $em->getRepository('gospelcenterLocationBundle:Location')->findOne($location);
        
        $response = new Response(json_encode($location));
        
        $response->headers->set('Content-Type', 'application/json');    
        
        return $response;
    }
}