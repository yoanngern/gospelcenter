<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\PageBundle\Entity\Slide;
use gospelcenter\PageBundle\Form\SlideType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminSlideController extends Controller
{


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Slide())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $slide = new Slide($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $slide)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Slide $slide
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Slide $slide)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $slide)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Slide $slide
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Slide $slide)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $slide)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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