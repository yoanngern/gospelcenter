<?php

namespace gospelcenter\CelebrationBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Celebration;
use gospelcenter\CelebrationBundle\Form\CelebrationType;
use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminCelebrationController extends Controller
{

    /**
     * @param Center $center
     * @Secure(roles="ROLE_USER")
     * @return Response
     * @throws AccessDeniedException
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Celebration($center))) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenter($center);

        return $this->render(
            'gospelcenterAdminBundle:Celebration:list.html.twig',
            array(
                'center' => $center,
                'celebrations' => $celebrations,
                'page' => 'celebrations'
            )
        );
    }


    /**
     * Add a celebration
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $celebration = new Celebration($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $celebration)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new CelebrationType($center), $celebration);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                if (count($celebration->getExistingSpeakers()) > 0) {
                    foreach ($celebration->getExistingSpeakers() as $speaker) {
                        $celebration->addSpeaker($speaker);
                        $em->persist($speaker);
                    }
                }

                if ($celebration->getVideo()) {
                    $em->persist($celebration->getVideo());
                    $em->flush();
                }

                $em->persist($celebration);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The celebration has been added.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_celebrations',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Celebration:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'celebrations'
            )
        );
    }


    /**
     * Edit a celebration
     * @Secure(roles="ROLE_USER")
     * @param $celebration = Celebration
     * @param $center = Center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Celebration $celebration)
    {

        if (false === $this->get('security.context')->isGranted("EDIT", $celebration)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $celebration->setStartingTime($celebration->getDate()->getStart());
        $celebration->setEndingTime($celebration->getDate()->getEnd());
        $celebration->setDateLocal($celebration->getDate()->getStart());

        if (count($celebration->getSpeakers())) {
            foreach ($celebration->getSpeakers() as $speaker) {
                $existingSpeaker[] = $speaker;
            }

            $celebration->setExistingSpeakers($existingSpeaker);
        }

        $request = $this->get('request');

        $form = $this->createForm(new CelebrationType($center), $celebration);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                // Remove all Speaker
                foreach ($celebration->getSpeakers() as $speaker) {
                    $celebration->removeSpeaker($speaker);
                    $em->persist($speaker);
                }

                if (count($celebration->getExistingSpeakers()) > 0) {
                    foreach ($celebration->getExistingSpeakers() as $speaker) {
                        $celebration->addSpeaker($speaker);
                        $em->persist($speaker);
                    }
                }

                if ($celebration->getVideo()) {
                    $em->persist($celebration->getVideo());
                    $em->flush();
                }

                $em->persist($celebration);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The celebration has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_celebrations',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        } else {

        }

        return $this->render(
            'gospelcenterAdminBundle:Celebration:edit.html.twig',
            array(
                'center' => $center,
                'celebration' => $celebration,
                'form' => $form->createView(),
                'page' => 'celebrations'
            )
        );
    }


    /**
     * Delete a celebration
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Celebration $celebration
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Celebration $celebration)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $celebration)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($celebration);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Celebration deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_celebrations',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterAdminBundle:Celebration:delete.html.twig',
            array(
                'center' => $center,
                'celebration' => $celebration,
                'form' => $form->createView(),
                'page' => 'celebrations'
            )
        );
    }
}