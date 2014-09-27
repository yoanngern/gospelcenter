<?php

namespace gospelcenter\AccessBundle\Controller;

use gospelcenter\AccessBundle\Entity\Unit;
use gospelcenter\AccessBundle\Form\UnitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UnitController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
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


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $unit = new Unit();
        $form = $this->createForm(new UnitType, $unit);
        
        $em = $this->getDoctrine()->getManager();
        
        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();
        
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
            'accesses' => $accesses,
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'units'
        ));
    }


    /**
     * @param Unit $unit
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Unit $unit)
    {   
        $form = $this->createForm(new UnitType, $unit);
        
        $em = $this->getDoctrine()->getManager();
        
        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();
        
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
            'accesses' => $accesses,
            'form' => $form->createView(),
            'page' => 'options',
            'tab' => 'units'
        ));
    }

    
}
