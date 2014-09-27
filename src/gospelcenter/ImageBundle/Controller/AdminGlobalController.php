<?php

namespace gospelcenter\ImageBundle\Controller;

use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\ImageBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminGlobalController extends Controller {


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllOrder();
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:list.html.twig', array(
            'images' => $images,
            'page' => 'images'
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $image = new Image();
        $form = $this->createForm(new ImageType, $image);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The image has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_images'));
            }
        }
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:add.html.twig', array(
            'form' => $form->createView(),
            'page' => 'images'
        ));
    }


    /**
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Image $image)
    {   
        $form = $this->createForm(new ImageType, $image);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The image has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdminGlobal_images'));
            }
        }
        
        return $this->render('gospelcenterImageBundle:AdminGlobal:edit.html.twig', array(
            'image' => $image,
            'form' => $form->createView(),
            'page' => 'images'
        ));
    }
}