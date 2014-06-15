<?php

namespace gospelcenter\AccessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Unit
use gospelcenter\AccessBundle\Entity\Unit;
use gospelcenter\AccessBundle\Form\UnitType;

// Access
use gospelcenter\AccessBundle\Entity\Access;
use gospelcenter\AccessBundle\Form\AccessType;

class AccessController extends Controller
{
    
    /*
     *   List of all accesses
     */
    public function listAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();
        
        return $this->render('gospelcenterAccessBundle:Access:list.html.twig', array(
            'accesses' => $accesses,
            'page' => 'options',
            'tab' => 'accesses'
        ));
    }
    
    
    /*
     *   Add an access
     */
    public function addAction()
    {
        $access = new Access();
        $form = $this->createForm(new AccessType, $access);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($access);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The access has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_options_accesses'));
            }
        }
        
        return $this->render('gospelcenterAccessBundle:Access:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'accesses'
        ));
    }
    
    
    /*
     *   Edit an access
     *   @param $access = Access
     */
    public function editAction(Access $access)
    {   
        $form = $this->createForm(new AccessType, $access);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($access);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The access has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_options_accesses'));
            }
        }
        
        return $this->render('gospelcenterAccessBundle:Access:edit.html.twig', array(
            'access' => $access,
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'accesses'
        ));
    }

    
}
