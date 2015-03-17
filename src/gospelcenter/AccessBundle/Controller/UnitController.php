<?php

namespace gospelcenter\AccessBundle\Controller;

use gospelcenter\AccessBundle\Entity\Unit;
use gospelcenter\AccessBundle\Form\UnitType;
use gospelcenter\CenterBundle\Entity\Center;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UnitController extends Controller
{

    /**
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Unit())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $units = $em->getRepository('gospelcenterAccessBundle:Unit')->findAll();

        return $this->render(
            'gospelcenterAdminBundle:Unit:list.html.twig',
            array(
                'center' => $center,
                'units' => $units,
                'page' => 'options',
                'tab' => 'units'
            )
        );
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Center $center)
    {
        $unit = new Unit();

        if (false === $this->get('security.context')->isGranted("CREATE", $unit)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new UnitType, $unit);

        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($unit);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The unit has been added.');

                return $this->redirect($this->generateUrl('gospelcenterAdmin_units'));
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Unit:add.html.twig',
            array(
                'center' => $center,
                'accesses' => $accesses,
                'form' => $form->createView(),
                'page' => 'options',
                'tab' => 'units'
            )
        );
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Unit $unit
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Unit $unit)
    {

        if (false === $this->get('security.context')->isGranted("EDIT", $unit)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new UnitType, $unit);

        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($unit);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The unit has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_units',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Unit:edit.html.twig',
            array(
                'center' => $center,
                'unit' => $unit,
                'accesses' => $accesses,
                'form' => $form->createView(),
                'page' => 'options',
                'tab' => 'units'
            )
        );
    }


    public function deleteAction(Center $center, Unit $unit)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $unit)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($unit);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Unit deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_units',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Unit:delete.html.twig',
            array(
                'center' => $center,
                'unit' => $unit,
                'form' => $form->createView(),
                'page' => 'options'
            )
        );
    }


}
