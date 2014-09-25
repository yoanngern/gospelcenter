<?php

namespace gospelcenter\CelebrationBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Celebration;
use gospelcenter\CelebrationBundle\Form\CelebrationType;
use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdminCelebrationController extends Controller
{

    /**
     * List of all celebrations
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenter($center);

        return $this->render(
            'gospelcenterCelebrationBundle:AdminCelebration:list.html.twig',
            array(
                'center' => $center,
                'celebrations' => $celebrations,
                'page' => 'celebrations'
            )
        );
    }


    /**
     * Add a celebration
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Center $center)
    {
        $celebration = new Celebration($center);

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
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterCelebrationBundle:AdminCelebration:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'celebrations'
            )
        );
    }


    /**
     *  Edit a celebration
     * @param $celebration = Celebration
     * @param $center = Center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Celebration $celebration)
    {

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
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        } else {

        }

        return $this->render(
            'gospelcenterCelebrationBundle:AdminCelebration:edit.html.twig',
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
     * @param Center $center
     * @param Celebration $celebration
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Celebration $celebration)
    {
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
                            'center' => $center->getRef()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterCelebrationBundle:AdminCelebration:delete.html.twig',
            array(
                'center' => $center,
                'celebration' => $celebration,
                'form' => $form->createView(),
                'page' => 'celebrations'
            )
        );
    }
}