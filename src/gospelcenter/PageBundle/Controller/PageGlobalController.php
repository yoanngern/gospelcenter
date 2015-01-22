<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageGlobalController extends Controller
{

    /**
     * @param $page
     * @param $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page, $template)
    {

        if($template == "slider") {

            $em = $this->getDoctrine()->getManager();

            $aPage = $em->getRepository('gospelcenterPageBundle:Page')->findAGlobalPage($page);

            if (!$page) {
                throw $this->createNotFoundException('This page doesn\'t exist');
            }

        } else {
            $template = $page;
            $aPage = null;
        }

        return $this->render(
            'gospelcenterPageBundle::global.html.twig',
            array(
                'page' => $page,
                'template' => $template,
                'article' => $aPage
            )
        );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxAction($page)
    {

        if($page == "ea" || $page == "vision") {
            $template = "slider";
        } else {
            $template = $page;
        }

        if($template == "slider") {

            $em = $this->getDoctrine()->getManager();

            $aPage = $em->getRepository('gospelcenterPageBundle:Page')->findAGlobalPage($page);

            if (!$page) {
                throw $this->createNotFoundException('This page doesn\'t exist');
            }

        } else {
            $template = $page;
            $aPage = null;
        }

        return $this->render(
            'gospelcenterPageBundle:PageGlobal:' . $template . 'New.html.twig',
            array(
                'page' => $page,
                'article' => $aPage
            )
        );
    }

}
