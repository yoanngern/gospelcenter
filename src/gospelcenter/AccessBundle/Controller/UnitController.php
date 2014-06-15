<?php

namespace gospelcenter\AccessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Unit
use gospelcenter\AccessBundle\Entity\Unit;
use gospelcenter\AccessBundle\Form\UnitType;

// Access
use gospelcenter\AccessBundle\Entity\Access;
use gospelcenter\AccessBundle\Form\AccessType;

class UnitController extends Controller
{
    
    /*
     *   List of all units
     */
    public function listAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $units = $em->getRepository('gospelcenterAccessBundle:Unit')->findAll();
        
        return $this->render('gospelcenterAccessBundle:Unit:list.html.twig', array(
            'units' => $units,
            'page' => 'options',
            'tab' => 'units'
        ));
    }
    
    
    /*
     *   Add a unit
     */
    public function addAction()
    {
        $unit = new Unit();
        $form = $this->createForm(new UnitType, $unit);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($unit);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The unit has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_options_units'));
            }
        }
        
        return $this->render('gospelcenterAccessBundle:Unit:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'units'
        ));
    }
    
    
    /*
     *   Edit a unit
     *   @param $unit = Unit
     */
    public function editAction(Unit $unit)
    {   
        $form = $this->createForm(new UnitType, $unit);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($unit);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The unit has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_options_units'));
            }
        }
        
        return $this->render('gospelcenterAccessBundle:Unit:edit.html.twig', array(
            'unit' => $unit,
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'units'
        ));
    }

    
}
