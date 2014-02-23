<?php

namespace gospelcenter\CelebrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Celebration
use gospelcenter\CelebrationBundle\Entity\Celebration;
use gospelcenter\CelebrationBundle\Form\CelebrationType;
use gospelcenter\CelebrationBundle\Form\CelebrationMobileType;

// Entity
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\CelebrationBundle\Entity\Tag;


class AdminCelebrationController extends Controller {
    
    /*
     *   List of all celebrations
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenter($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterCelebrationBundle:MobileCelebration:list.html.twig', array(
                'center' => $center,
                'celebrations' => $celebrations,
                'page' => 'celebrations'
            ));
        }
        
        return $this->render('gospelcenterCelebrationBundle:AdminCelebration:list.html.twig', array(
            'center' => $center,
            'celebrations' => $celebrations,
            'page' => 'celebrations'
        ));
    }
    
    
    /*
     *   Add a celebration
     */
    public function addAction(Center $center)
    {
        $celebration = new celebration($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile()) {
            $form = $this->createForm(new CelebrationMobileType, $celebration);
        } else {
            $form = $this->createForm(new CelebrationType, $celebration);
        }
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                
                if(count($celebration->getExistingSpeakers()) > 0) {
                    foreach($celebration->getExistingSpeakers() as $speaker) {
                        $celebration->addSpeaker($speaker);
                        $em->persist($speaker);
                    }
                }
                
                $em->persist($celebration);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The celebration has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_celebrations', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterCelebrationBundle:MobileCelebration:add.html.twig', array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'celebrations'
            ));
        }
        
        return $this->render('gospelcenterCelebrationBundle:AdminCelebration:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'celebrations'
        ));
    }
    
    
    /*
     *   Edit a celebration
     *   @param $celebration = Celebration
     *   @param $center = Center
     */
    public function editAction(Center $center, Celebration $celebration)
    {   
        
        if(count($celebration->getSpeakers())) {
            foreach($celebration->getSpeakers() as $speaker) {
                $existingSpeaker[] = $speaker;
            }
            
            $celebration->setExistingSpeakers($existingSpeaker);
        }
        
        $celebration->setDate($celebration->getStartingDate());
        $celebration->setStartingTime($celebration->getStartingDate());
        $celebration->setEndingTime($celebration->getEndingDate());
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile()) {
            $form = $this->createForm(new CelebrationMobileType, $celebration);
        } else {
            $form = $this->createForm(new CelebrationType, $celebration);
        }
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                // Remove all Speaker
                foreach($celebration->getSpeakers() as $speaker) {
                    $celebration->removeSpeaker($speaker);
                    $em->persist($speaker);
                }
                
                if(count($celebration->getExistingSpeakers()) > 0) {
                    foreach($celebration->getExistingSpeakers() as $speaker) {
                        $celebration->addSpeaker($speaker);
                        $em->persist($speaker);
                    }
                }
                
                $em->persist($celebration);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The celebration has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_celebrations', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterCelebrationBundle:MobileCelebration:edit.html.twig', array(
                'center' => $center,
                'celebration' => $celebration,
                'form' => $form->createView(),
                'page' => 'celebrations'
            ));
        }
        
        return $this->render('gospelcenterCelebrationBundle:AdminCelebration:edit.html.twig', array(
            'center' => $center,
            'celebration' => $celebration,
            'form' => $form->createView(),
            'page' => 'celebrations'
        ));
    }
    
    
    /*
     *   Delete a celebration
     */
    public function deleteAction(Center $center, Celebration $celebration)
    {      
        return $this->redirect( $this->generateUrl('gospelcenterAdmin_celebrations', array(
            'center' => $center->getRef()
        )));
    }
}