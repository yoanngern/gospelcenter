<?php

namespace gospelcenter\EventBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\EventBundle\Entity\Event;
use gospelcenter\EventBundle\Form\EventType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminController extends Controller
{

    /**
     * List of next events
     * @Secure(roles="ROLE_USER")
     * @param $center = Center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Event())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('gospelcenterEventBundle:Event')->findNextByCenterWithHidden($center);

        return $this->render(
            'gospelcenterEventBundle:Admin:list.html.twig',
            array(
                'center' => $center,
                'events' => $events,
                'page' => 'events',
                'tab' => 'nextEvents'
            )
        );
    }


    /**
     * List of past events
     * @Secure(roles="ROLE_USER")
     * @param $center = Center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pastAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Event())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('gospelcenterEventBundle:Event')->findPastByCenterWithHidden($center);

        return $this->render(
            'gospelcenterEventBundle:Admin:list.html.twig',
            array(
                'center' => $center,
                'events' => $events,
                'page' => 'events',
                'tab' => 'pastEvents'
            )
        );
    }


    /**
     * Add an event
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Center $center)
    {
        $event = new Event($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $event)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new EventType($center, $this), $event);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $event->addCenter($center);

                if ($event->getVideo()) {
                    $em->persist($event->getVideo());
                    $em->flush();
                }

                $em->persist($event);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The event has been added.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_events',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterEventBundle:Admin:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'events'
            )
        );
    }


    /**
     * Edit an event
     * @Secure(roles="ROLE_USER")
     * @param \gospelcenter\CenterBundle\Entity\Center $center
     * @param \gospelcenter\EventBundle\Entity\Event $event = Event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Center $center, Event $event)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $event)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new EventType($center, $this), $event);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                if ($event->getVideo()) {
                    $em->persist($event->getVideo());
                    $em->flush();
                }

                $em->persist($event);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The event has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_events',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterEventBundle:Admin:edit.html.twig',
            array(
                'center' => $center,
                'event' => $event,
                'form' => $form->createView(),
                'page' => 'events'
            )
        );
    }


    /**
     * Delete a event
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Center $center, Event $event)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $event)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($event);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Event deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_events',
                        array(
                            'center' => $center->getRef(), 'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterEventBundle:Admin:delete.html.twig',
            array(
                'center' => $center,
                'event' => $event,
                'form' => $form->createView(),
                'page' => 'events'
            )
        );
    }

}