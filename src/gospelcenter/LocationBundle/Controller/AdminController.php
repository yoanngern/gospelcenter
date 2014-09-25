<?php

namespace gospelcenter\LocationBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\LocationBundle\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{

    /**
     * List of all locations
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('gospelcenterLocationBundle:Location')->findAllByCenter($center);

        return $this->render(
            'gospelcenterAdminBundle:Location:list.html.twig',
            array(
                'center' => $center,
                'locations' => $locations,
                'page' => 'locations',
                'tab' => 'locations'
            )
        );
    }


    /**
     * Add a location
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $location = new Location();
        $form = $this->createForm(new LocationType, $location);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $location->setCenterCreator($center);

                $em->persist($location);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The location has been added.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_locations',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Location:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'locations'
            )
        );
    }


    /**
     * Edit a location
     * @param Center $center
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Location $location)
    {
        $form = $this->createForm(new LocationType, $location);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($location);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The location has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_locations',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Location:edit.html.twig',
            array(
                'center' => $center,
                'location' => $location,
                'form' => $form->createView(),
                'page' => 'locations'
            )
        );
    }


    /**
     * Delete a location
     * @param Center $center
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Location $location)
    {
        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($location);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Location deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_locations',
                        array(
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Location:delete.html.twig',
            array(
                'center' => $center,
                'location' => $location,
                'form' => $form->createView(),
                'page' => 'locations'
            )
        );
    }
}