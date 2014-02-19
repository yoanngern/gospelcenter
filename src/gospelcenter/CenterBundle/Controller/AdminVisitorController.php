<?php

namespace gospelcenter\CenterBundle\Controller;

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

// Member
use gospelcenter\CenterBundle\Entity\Member;
use gospelcenter\CenterBundle\Form\MemberType;

// Visitor
use gospelcenter\CenterBundle\Entity\Visitor;
use gospelcenter\CenterBundle\Form\VisitorType;

// People
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\PeopleBundle\Form\PersonType;


class AdminVisitorController extends Controller {
    
    /*
     *   List of visitor
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $visitors = $em->getRepository('gospelcenterCenterBundle:Visitor')->findAllByCenter($center);
        
        return $this->render('gospelcenterCenterBundle:AdminVisitor:list.html.twig', array(
            'center' => $center,
            'visitors' => $visitors,
            'page' => 'people',
            'tab' => 'visitors'
        ));
    }
    
    /*
    *   Add a visitor
    */
    public function addAction(Center $center)
    {
        
        $visitor = new Visitor();
        $form = $this->createForm(new MemberType, $visitor);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($visitor);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_visitors', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminVisitor:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'people',
            'visitor' => $visitor
        ));
    }
    
    /*
    *   Edit a visitor
    */
    public function editAction(Center $center, Member $visitor)
    {
        $form = $this->createForm(new VisitorType, $visitor);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($visitor);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_visitors', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminVisitor:edit.html.twig', array(
            'center' => $center,
            'visitor' => $visitor,
            'form' => $form->createView(),
            'page' => 'people'
        ));
    }    
}