<?php

namespace gospelcenter\ImageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\ImageBundle\Form\ImageType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminController extends Controller
{

    /**
     * List of images
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Image())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllByCenter($center);

        return $this->render('gospelcenterAdminBundle:Image:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'options',
            'tab' => 'images'
        ));
    }


    /**
     * List of all images
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function allAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Image())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllOrder();

        return $this->render('gospelcenterAdminBundle:Image:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'options',
            'tab' => 'imagesAll'
        ));
    }


    /**
     * Add an image
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $image = new Image();

        if (false === $this->get('security.context')->isGranted("CREATE", $image)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new ImageType, $image);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The image has been added.');

                return $this->redirect($this->generateUrl('gospelcenterAdmin_images', array(
                    'center' => $center->getRef()
                )));
            }
        }

        return $this->render('gospelcenterAdminBundle:Image:add.html.twig', array(
            'center' => $center,
            'form' => $form->createView(),
            'page' => 'options'
        ));
    }


    /**
     * Edit an image
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Image $image)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $image)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new ImageType, $image);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The image has been edited.');

                return $this->redirect($this->generateUrl('gospelcenterAdmin_images', array(
                    'center' => $center->getRef()
                )));
            }
        }

        return $this->render('gospelcenterAdminBundle:Image:edit.html.twig', array(
            'center' => $center,
            'image' => $image,
            'form' => $form->createView(),
            'page' => 'options'
        ));
    }


    /**
     * Delete a slide
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Image $image)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $image)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($image);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Image deleted.');

                return $this->redirect($this->generateUrl('gospelcenterAdmin_images', array(
                    'center' => $center->getRef()
                )));
            }
        }

        return $this->render('gospelcenterAdminBundle:Image:delete.html.twig', array(
            'center' => $center,
            'image' => $image,
            'form' => $form->createView(),
            'page' => 'options'
        ));
    }
}