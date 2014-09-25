<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\PageBundle\Entity\Slide;
use gospelcenter\PageBundle\Form\SlideType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdminSlideController extends Controller
{

    /*
     *   List of slides
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $slides = $em->getRepository('gospelcenterPageBundle:Slide')->findAllByCenter($center);

        return $this->render(
            'gospelcenterPageBundle:AdminSlide:list.html.twig',
            array(
                'center' => $center,
                'slides' => $slides,
                'page' => 'pages',
                'tab' => 'slides'
            )
        );
    }


    /*
     *   Add a slide
     */
    public function addAction(Center $center)
    {
        $slide = new Slide($center);
        $form = $this->createForm(new SlideType($center), $slide);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The slide has been added.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_slides',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPageBundle:AdminSlide:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'pages'
            )
        );
    }


    /**
     * @param Center $center
     * @param Slide $slide
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Slide $slide)
    {
        $form = $this->createForm(new SlideType($center), $slide);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The slide has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_slides',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPageBundle:AdminSlide:edit.html.twig',
            array(
                'center' => $center,
                'slide' => $slide,
                'form' => $form->createView(),
                'page' => 'pages'
            )
        );
    }


    /*
     *   Delete a slide
     */
    public function deleteAction(Center $center, Slide $slide)
    {
        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($slide);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Slide deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_slides',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPageBundle:AdminSlide:delete.html.twig',
            array(
                'center' => $center,
                'slide' => $slide,
                'form' => $form->createView(),
                'page' => 'pages'
            )
        );
    }

}