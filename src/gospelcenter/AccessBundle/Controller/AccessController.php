<?php

namespace gospelcenter\AccessBundle\Controller;

use gospelcenter\AccessBundle\Entity\Access;
use gospelcenter\AccessBundle\Form\AccessType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessController extends Controller
{


    /**
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Access())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository('gospelcenterAccessBundle:Access')->findAll();

        return $this->render(
            'gospelcenterAdminBundle:Access:list.html.twig',
            array(
                'accesses' => $accesses,
                'page' => 'options',
                'tab' => 'accesses'
            )
        );
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $access = new Access();

        if (false === $this->get('security.context')->isGranted("CREATE", $access)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new AccessType, $access);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($access);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The access has been added.');

                return $this->redirect($this->generateUrl('gospelcenterAdminGlobal_accesses'));
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Access:add.html.twig',
            array(
                'form' => $form->createView(),
                'page' => 'options',
                'tab' => 'accesses'
            )
        );
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Access $access
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Access $access)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $access)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new AccessType, $access);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($access);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The access has been edited.');

                return $this->redirect($this->generateUrl('gospelcenterAdminGlobal_accesses'));
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Access:edit.html.twig',
            array(
                'access' => $access,
                'form' => $form->createView(),
                'page' => 'options',
                'tab' => 'accesses'
            )
        );
    }


    /**
     * @param Access $access
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Access $access)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $access)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($access);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Access deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdminGlobal_accesses'
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Access:delete.html.twig',
            array(
                'access' => $access,
                'form' => $form->createView(),
                'page' => 'options'
            )
        );
    }

}
