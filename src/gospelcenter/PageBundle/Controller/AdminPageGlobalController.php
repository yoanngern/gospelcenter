<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageGlobalAddType;
use gospelcenter\PageBundle\Form\PageGlobalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdminPageGlobalController extends Controller
{


    /**
     * @return Response
     */
    public function redirectAction()
    {
        return $this->redirect(
            $this->generateUrl(
                'gospelcenterPage_home',
                array(
                    'center' => 'lausanne'
                )
            )
        );
    }


    /**
     * @return Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findAllGlobal();

        return $this->render(
            'gospelcenterPageBundle:AdminPageGlobal:list.html.twig',
            array(
                'pages' => $pages,
                'page' => 'pages',
                'tab' => 'pages'
            )
        );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction()
    {
        $page = new Page();
        $form = $this->createForm(new PageGlobalAddType, $page);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The page has been added.');

                return $this->redirect($this->generateUrl('gospelcenterAdminGlobal_pages'));
            }
        }

        return $this->render(
            'gospelcenterPageBundle:AdminPageGlobal:add.html.twig',
            array(
                'form' => $form->createView(),
                'page' => 'pages',
                'article' => $page
            )
        );
    }


    /**
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Page $page)
    {
        $form = $this->createForm(new PageGlobalType, $page);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($page);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The page has been edited.');

                return $this->redirect($this->generateUrl('gospelcenterAdminGlobal_pages'));
            }
        }

        return $this->render(
            'gospelcenterPageBundle:AdminPageGlobal:edit.html.twig',
            array(
                'objPage' => $page,
                'form' => $form->createView(),
                'page' => 'pages',
                'article' => $page
            )
        );
    }


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Center $center)
    {
        return $this->redirect(
            $this->generateUrl(
                'gospelcenterAdmin_locations',
                array(
                    'center' => $center->getRef()
                )
            )
        );
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