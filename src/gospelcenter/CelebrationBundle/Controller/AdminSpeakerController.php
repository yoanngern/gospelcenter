<?php

namespace gospelcenter\CelebrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Image
use gospelcenter\ImageBundle\Entity\Image;

// Location
use gospelcenter\LocationBundle\Entity\Location;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Speaker
use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CelebrationBundle\Form\SpeakerType;


class AdminSpeakerController extends Controller {
    
    /*
     *   List of speakers
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllByCenter($center);
        
        return $this->render('gospelcenterCelebrationBundle:AdminSpeaker:list.html.twig', array(
            'center' => $center,
            'speakers' => $speakers,
            'page' => 'people',
            'tab' => 'speakers'
        ));
    }
    
    /*
     *   List of all speakers
     */
    public function allAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllOrder();
        
        return $this->render('gospelcenterCelebrationBundle:AdminSpeaker:list.html.twig', array(
            'center' => $center,
            'speakers' => $speakers,
            'page' => 'people',
            'tab' => 'speakersAll'
        ));
    }
    
    /*
     *   Add a location
     */
    public function addAction(Center $center)
    {
        
        $speaker = new Speaker();
        $form = $this->createForm(new SpeakerType, $speaker);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($speaker);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_speakers', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCelebrationBundle:AdminSpeaker:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'speakers'
        ));
    }
    
    /*
     *   Edit a speaker
     */
    public function editAction(Center $center, Speaker $speaker)
    {
        $form = $this->createForm(new SpeakerType, $speaker);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($speaker);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_speakers', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCelebrationBundle:AdminSpeaker:edit.html.twig', array(
            'center' => $center,
            'speaker' => $speaker,
            'form' => $form->createView(),
            'page' => 'speakers'
        ));
    }
    
    
    /*
     *   All speakers in JSON
     *   @param Center
     *   @return all speakers in JSON
     */
    public function jsonAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllJSON();
        
        $response = new Response(json_encode($speakers));
        
        $response->headers->set('Content-Type', 'application/json');    
        
        return $response;
    }
    
    /*
     *   Get JSON speaker
     *   @param $speaker = speaker id
     *          $center = Center
     */
    public function singleJSONAction(Center $center, $speaker)
    {   
        
        $em = $this->getDoctrine()->getManager();
        
        $speaker = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findOne($speaker);
        
        $response = new Response(json_encode($speaker));
        
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}