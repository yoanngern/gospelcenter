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

// Speaker
use gospelcenter\CenterBundle\Entity\Member;
use gospelcenter\CenterBundle\Form\MemberType;

// People
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\PeopleBundle\Form\PersonType;


class AdminMemberController extends Controller {
    
    /*
     *   List of member
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $members = $em->getRepository('gospelcenterCenterBundle:Member')->findAllByCenter($center);
        
        return $this->render('gospelcenterCenterBundle:AdminMember:list.html.twig', array(
            'center' => $center,
            'members' => $members,
            'page' => 'people',
            'tab' => 'members'
        ));
    }
    
    /*
    *   Add a member
    */
    public function addAction(Center $center)
    {
        
        $member = new Member();
        $form = $this->createForm(new MemberType, $member);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($member);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_members', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminMember:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'people',
            'member' => $member
        ));
    }
    
    /*
    *   Edit a person
    */
    public function editAction(Center $center, Member $member)
    {
        $form = $this->createForm(new MemberType, $member);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($member);
                $em->flush();
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_members', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminMember:edit.html.twig', array(
            'center' => $center,
            'member' => $member,
            'form' => $form->createView(),
            'page' => 'people'
        ));
    }    
}