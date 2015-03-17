<?php

namespace gospelcenter\LocationBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\LocationBundle\Form\LocationType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminController extends Controller
{

    /**
     * List of all locations
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Location())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('gospelcenterLocationBundle:Location')->findAllByCenter($center);

        return $this->render(
            'gospelcenterAdminBundle:Location:list.html.twig',
            array(
                'center' => $center,
                'locations' => $locations,
                'page' => 'options',
                'tab' => 'locations'
            )
        );
    }


    /**
     * Add a location
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $location = new Location();

        if (false === $this->get('security.context')->isGranted("CREATE", $location)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
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
                'page' => 'options'
            )
        );
    }


    /**
     * Edit a location
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Center $center, Location $location)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $location)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
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
                'page' => 'options'
            )
        );
    }


    /**
     * Delete a location
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Location $location)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $location)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

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
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
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
                'page' => 'options'
            )
        );
    }
}