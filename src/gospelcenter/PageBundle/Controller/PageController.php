<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{

    /**
     * @param Center $center
     * @param $_locale
     * @param string $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Center $center, $_locale, $page = 'home')
    {
        $default_language = "fr";
        $language = $_locale;

        $em = $this->getDoctrine()->getManager();

        if ($page == "youth") {
            $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center, $page, $language);

            if(sizeof($pages) == 0) {
                $language = $default_language;
                $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center, $page, $language);
            }

            if(sizeof($pages) != 0) {

                $page = $pages[0]->getAlias();

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
        }

        $aPage = $em->getRepository('gospelcenterPageBundle:Page')->findAPage($center, $page, $language);

        if (!$aPage) {
            $aPage = $em->getRepository('gospelcenterPageBundle:Page')->findAPage($center, $page, $default_language);
        }

        if (!$aPage) {

            $pages = $em->getRepository('gospelcenterPageBundle:Page')->findYouthPages($center, "youth", $language);

            if(sizeof($pages) != 0) {
                return $this->render(
                    'gospelcenterPageBundle:Page:youth.html.twig',
                    array(
                        'center' => $center,
                        'page' => 'youth',
                        'pages' => $pages,
                        'group' => $page
                    )
                );
            } else {
                throw $this->createNotFoundException('This page doesn\'t exist');
            }


        } else {
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

    }

    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param Center $center
     * @param string $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param Center $center
     * @param $_locale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction(Center $center, $_locale)
    {

        $language = $_locale;

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

    /**
     * @param Center $center
     * @param $_locale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Center $center, $_locale)
    {

        $language = $_locale;

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

    /**
     * @param Center $center
     * @param $_locale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function giveAction(Center $center, $_locale)
    {

        $language = $_locale;

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
