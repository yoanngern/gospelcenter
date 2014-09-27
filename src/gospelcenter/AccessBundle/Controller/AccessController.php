<?php

namespace gospelcenter\AccessBundle\Controller;

use gospelcenter\AccessBundle\Entity\Access;
use gospelcenter\AccessBundle\Form\AccessType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccessController extends Controller
{


    /**
     * @return \Symfony\Component\HttpFoundation\Response
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


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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


    /**
     * @param Access $access
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
