<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\PageBundle\Entity\Slide;
use gospelcenter\PageBundle\Form\SlideType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdminSlideGlobalController extends Controller {


    /**
     * @return Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $slides = $em->getRepository('gospelcenterPageBundle:Slide')->findAllGlobal();
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:list.html.twig', array(
            'slides' => $slides,
            'page' => 'pages',
            'tab' => 'slides'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction()
    {
        $slide = new Slide();
        $form = $this->createForm(new SlideType, $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The slide has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_slides'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'pages'
        ));
    }


    /**
     * @param Slide $slide
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Slide $slide)
    {   
        $form = $this->createForm(new SlideType, $slide);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The slide has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_slides'));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminSlideGlobal:edit.html.twig', array(
            'slide' => $slide,
            'form' => $form->createView(),
            'page' => 'pages'
        ));
    }


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Center $center)
    {      
        return $this->redirect( $this->generateUrl('gospelcenterAdmin_locations', array(
            'center' => $center->getRef()
        )));
    }


    /**
     * @param $location
     * @return Response
     */
    public function singleJSONAction($location)
    {   
        
        $em = $this->getDoctrine()->getManager();
        
        $location = $em->getRepository('gospelcenterLocationBundle:Location')->findOne($location);
        
        $response = new Response(json_encode($location));
        
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}