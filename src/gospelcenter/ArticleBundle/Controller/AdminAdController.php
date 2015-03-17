<?php

namespace gospelcenter\ArticleBundle\Controller;

use gospelcenter\ArticleBundle\Entity\Ad;
use gospelcenter\ArticleBundle\Form\AdType;
use gospelcenter\CenterBundle\Entity\Center;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminAdController extends Controller {

    /**
     * List of all ads
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Ad())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();
        
        $ads = $em->getRepository('gospelcenterArticleBundle:Ad')->findAllByCenter($center);
        
        return $this->render('gospelcenterArticleBundle:AdminAd:list.html.twig', array(
            'center' => $center,
            'ads' => $ads,
            'page' => 'ads'
        ));
    }


    /**
     * Add an ad
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Center $center)
    {
        $ad = new Ad($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $ad)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
                    'center' => $center->getRef(), 'domain' => $center->getDomain()
                )));
            }
        }
        
        return $this->render('gospelcenterArticleBundle:AdminAd:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'ads'
        ));
    }


    /**
     * Edit a location
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Ad $ad
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Ad $ad)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $ad)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
                    'center' => $center->getRef(), 'domain' => $center->getDomain()
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


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Ad $ad
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Center $center, Ad $ad)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $ad)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($ad);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Ad deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_ads',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterArticleBundle:AdminAd:delete.html.twig',
            array(
                'center' => $center,
                'ad' => $ad,
                'form' => $form->createView(),
                'page' => 'ads'
            )
        );
    }

}