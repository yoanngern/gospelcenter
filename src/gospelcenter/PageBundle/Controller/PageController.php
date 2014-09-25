<?php

namespace gospelcenter\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Page
use gospelcenter\PageBundle\Entity\Page;
use gospelcenter\PageBundle\Form\PageType;

// Center
use gospelcenter\CenterBundle\Entity\Center;

class PageController extends Controller
{
    public function indexAction(Center $center, $page = 'home')
    {

        $language = 'fr';

        $em = $this->getDoctrine()->getManager();

        if ($page == "youth") {
            $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center);

            $page = $pages[0]->getAlias();

            if (!$page) {
                $page = $pages[0]->getTitle();
            }
        }

        $aPage = $em->getRepository('gospelcenterPageBundle:Page')->findAPage($center, $page);

        if (!$aPage) {

            $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center);

            return $this->render(
                'gospelcenterPageBundle:Page:youth.html.twig',
                array(
                    'center' => $center,
                    'page' => 'youth',
                    'pages' => $pages,
                    'group' => $page
                )
            );

        }


        return $this->render(
            'gospelcenterPageBundle:Page:index.html.twig',
            array(
                'center' => $center,
                'page' => $aPage->getRef(),
                'language' => $language,
                'article' => $aPage
            )
        );
    }

    public function homeAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $centerFound = $em->getRepository('gospelcenterCenterBundle:Center')->getHomeData($center);

        return $this->render(
            'gospelcenterPageBundle:Page:home.html.twig',
            array(
                'center' => $centerFound,
                'page' => 'home'
            )
        );
    }

    public function youthAction(Center $center, $group = "minis")
    {

        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center);

        $page = $em->getRepository('gospelcenterPageBundle:Page')->findAYouthGroup($center, $group);

        if (!$page) {
            throw $this->createNotFoundException('This group doesn\'t exist');
        }

        return $this->render(
            'gospelcenterPageBundle:Page:youth.html.twig',
            array(
                'center' => $center,
                'page' => 'youth',
                'pages' => $pages,
                'group' => $page
            )
        );
    }

    public function aboutAction(Center $center)
    {

        $language = 'fr';


        return $this->render(
            'gospelcenterPageBundle::staticPage.html.twig',
            array(
                'center' => $center,
                'language' => $language,
                'folder' => 'about',
                'template' => 'about',
                'page' => 'about',
                'customClass' => 'simple'
            )
        );
    }

    public function contactAction(Center $center)
    {

        $language = 'fr';


        return $this->render(
            'gospelcenterPageBundle::staticPage.html.twig',
            array(
                'center' => $center,
                'language' => $language,
                'template' => 'contact',
                'page' => 'contact'
            )
        );
    }

    public function giveAction(Center $center)
    {

        $language = 'fr';

        return $this->render(
            'gospelcenterPageBundle::staticPage.html.twig',
            array(
                'center' => $center,
                'language' => $language,
                'template' => 'give',
                'page' => 'give'
            )
        );
    }
}
