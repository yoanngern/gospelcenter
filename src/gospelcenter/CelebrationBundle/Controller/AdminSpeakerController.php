<?php

namespace gospelcenter\CelebrationBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CelebrationBundle\Form\SpeakerType;
use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
}