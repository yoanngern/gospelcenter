<?php

namespace gospelcenter\CenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


// Location
use gospelcenter\LocationBundle\Entity\Location;

// Center
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\CenterBundle\Form\CenterType;
use gospelcenter\CenterBundle\Form\CenterEditType;


class AdminCenterController extends Controller {
    
    /*
     *   List of centers
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $centers = $em->getRepository('gospelcenterCenterBundle:Center')->findAll();
        
        return $this->render('gospelcenterCenterBundle:AdminCenter:list.html.twig', array(
            'centers' => $centers,
            'page' => 'centers'
        ));
    }
    
    /*
    *   Add a center
    */
    public function addAction()
    {
        
        $center = new Center();
        $form = $this->createForm(new CenterType, $center);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($center);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The center has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_centers'));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminCenter:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'centers'
        ));
    }
    
    /*
    *   Edit a center
    */
    public function editAction(Center $center)
    {
        $form = $this->createForm(new CenterEditType, $center);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($center);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The center has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_centers'));
            }
        }
        
        return $this->render('gospelcenterCenterBundle:AdminCenter:edit.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'centers'
        ));
    }    
}