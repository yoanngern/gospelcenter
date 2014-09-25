<?php

namespace gospelcenter\ArticleBundle\Controller;

use gospelcenter\ArticleBundle\Entity\Ad;
use gospelcenter\ArticleBundle\Form\AdType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Center
use gospelcenter\CenterBundle\Entity\Center;


class AdminAdController extends Controller {
    
    /*
     *   List of all ads
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $ads = $em->getRepository('gospelcenterArticleBundle:Ad')->findAllByCenter($center);
        
        return $this->render('gospelcenterArticleBundle:AdminAd:list.html.twig', array(
            'center' => $center,
            'ads' => $ads,
            'page' => 'ads'
        ));
    }
    
    
    /*
     *   Add an ad
     */
    public function addAction(Center $center)
    {
        $ad = new Ad($center);
        $form = $this->createForm(new AdType, $ad);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($ad);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The ad has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_ads', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterArticleBundle:AdminAd:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'ads'
        ));
    }
    
    
    /*
     *   Edit a location
     *   @param $ad = Ad
     *          $center = Center
     */
    public function editAction(Center $center, Ad $ad)
    {   
        $form = $this->createForm(new AdType, $ad);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {

            $form->bind($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ad);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The ad has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_ads', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterArticleBundle:AdminAd:edit.html.twig', array(
            'center' => $center,
            'ad' => $ad,
            'form' => $form->createView(),
            'page' => 'ads'
        ));
    }
    
    
    /*
     *   Delete a location
     */
    public function deleteAction(Center $center, Location $location)
    {   
        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($location);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'Location deleted.');
        
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_locations', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterLocationBundle:Admin:delete.html.twig', array(
              'center' => $center,
              'location' => $location,
              'form'    => $form->createView(),
              'page' => 'locations'
        ));
    }
}