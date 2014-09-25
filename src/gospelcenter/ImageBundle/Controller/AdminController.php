<?php

namespace gospelcenter\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Image
use gospelcenter\ImageBundle\Entity\Image;
use gospelcenter\ImageBundle\Form\ImageType;


class AdminController extends Controller
{

    /**
     * List of images
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllByCenter($center);

        return $this->render('gospelcenterAdminBundle:Image:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'images',
            'tab' => 'images'
        ));
    }


    /**
     * List of all images+
     * @param Center $center
     * @return Response
     */
    public function allAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('gospelcenterImageBundle:Image')->findAllOrder();

        return $this->render('gospelcenterAdminBundle:Image:list.html.twig', array(
            'center' => $center,
            'images' => $images,
            'page' => 'images',
            'tab' => 'imagesAll'
        ));
    }


    /**
     * Add an image
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $image = new Image();
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
            'page' => 'images'
        ));
    }


    /**
     * Edit an image
     * @param Center $center
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Image $image)
    {
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
            'page' => 'images'
        ));
    }


    /**
     * Delete a slide
     * @param Center $center
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Image $image)
    {
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
            'page' => 'images'
        ));
    }
}