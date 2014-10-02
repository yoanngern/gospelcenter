<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageAddType;
use gospelcenter\PageBundle\Form\PageType;
use gospelcenter\PageBundle\Form\YouthPageType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminPageController extends Controller {


    /**
     * @param Center $center
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Page())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();
        
        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findAllByCenter($center);
        
        return $this->render('gospelcenterPageBundle:AdminPage:list.html.twig', array(
            'center' => $center,
            'pages' => $pages,
            'page' => 'pages',
            'tab' => 'pages'
        ));
    }


    /**
     * @param Center $center
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Center $center)
    {
        $page = new Page($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $page)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new PageAddType($center), $page);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The page has been added.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Page $page)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $page)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new PageType($center), $page);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The page has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:edit.html.twig', array(
            'center' => $center,
            'objPage' => $page,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Center $center, Page $page)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $page)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'Page deleted.');
        
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_pages', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:delete.html.twig', array(
              'center' => $center,
              'objPage' => $page,
              'form'    => $form->createView(),
              'page' => 'pages'
        ));
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function youthAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthByCenter($center);

        if (false === $this->get('security.context')->isGranted("VIEW", $pages[0])) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:youth.html.twig', array(
            'center' => $center,
            'pages' => $pages,
            'page' => 'pages',
            'tab' => 'youth'
        ));
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function youthEditAction(Center $center, Page $page)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $page)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new YouthPageType($center), $page);
        
        $request = $this->get('request');
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info', 'The page has been edited.');
                
                return $this->redirect( $this->generateUrl('gospelcenterAdmin_youth', array(
                    'center' => $center->getRef()
                )));
            }
        }
        
        return $this->render('gospelcenterPageBundle:AdminPage:youthEdit.html.twig', array(
            'center' => $center,
            'objPage' => $page,
            'form' => $form->createView(),
            'page' => 'pages',
            'article' => $page
        ));
    }
}