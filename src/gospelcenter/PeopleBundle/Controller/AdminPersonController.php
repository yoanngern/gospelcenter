<?php

namespace gospelcenter\PeopleBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\CenterBundle\Entity\Member;
use gospelcenter\CenterBundle\Entity\Visitor;
use gospelcenter\PeopleBundle\Entity\Person;
use gospelcenter\PeopleBundle\Form\PersonType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use gospelcenter\PeopleBundle\Form\PersonWithAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminPersonController extends Controller
{

    /**
     * List of person
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Person())) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        $persons = $em->getRepository('gospelcenterPeopleBundle:Person')->findAllByCenter($center);

        return $this->render(
            'gospelcenterPeopleBundle:AdminPerson:list.html.twig',
            array(
                'center' => $center,
                'persons' => $persons,
                'page' => 'people',
                'tab' => 'contacts'
            )
        );
    }


    /**
     * Add a person
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return Response
     */
    public function addAction(Center $center)
    {

        $person = new Person($center);

        if (false === $this->get('security.context')->isGranted("CREATE", $person)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new PersonType, $person);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $em->persist($person);
                $em->flush();

                $this->setSpeaker($person);
                $this->setMember($person, $center);
                $this->setVisitor($person, $center);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The contact has been added.');


                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_persons',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPeopleBundle:AdminPerson:add.html.twig',
            array(
                'center' => $center,
                'form' => $form->createView(),
                'page' => 'people',
                'person' => $person
            )
        );
    }

    /**
     * Edit a person
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Person $person
     * @return Response
     */
    public function editAction(Center $center, Person $person)
    {
        if (false === $this->get('security.context')->isGranted("EDIT", $person)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();

        if ($person->getSpeaker() != null) {
            $person->setIsSpeaker(true);
        }

        if ($person->getVisitor() != null) {

            foreach ($person->getVisitor()->getCenters() as $localCenter) {
                if ($localCenter->getRef() == $center->getRef()) {
                    $person->setIsVisitor(true);
                }
            }
        }

        if ($person->getMember() != null) {

            foreach ($person->getMember()->getCenters() as $localCenter) {
                if ($localCenter->getRef() == $center->getRef()) {
                    $person->setIsMember(true);
                }
            }
        }

        if ($person->getUser()) {
            $form = $this->createForm(new PersonWithAccountType, $person);
        } else {
            $form = $this->createForm(new PersonType, $person);
        }

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $this->setSpeaker($person);
                $this->setMember($person, $center);
                $this->setVisitor($person, $center);

                $em->persist($person);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The contact has been edited.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_persons',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPeopleBundle:AdminPerson:edit.html.twig',
            array(
                'center' => $center,
                'person' => $person,
                'form' => $form->createView(),
                'page' => 'people'
            )
        );
    }


    /**
     * Delete a person
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @param Person $person
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Center $center, Person $person)
    {
        if (false === $this->get('security.context')->isGranted("REMOVE", $person)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($person);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Contact deleted.');

                return $this->redirect(
                    $this->generateUrl(
                        'gospelcenterAdmin_persons',
                        array(
                            'center' => $center->getRef(),
                            'domain' => $center->getDomain()
                        )
                    )
                );
            }
        }

        return $this->render(
            'gospelcenterPeopleBundle:AdminPerson:delete.html.twig',
            array(
                'center' => $center,
                'person' => $person,
                'form' => $form->createView(),
                'page' => 'people'
            )
        );
    }

    /**
     * Set a speaker
     * @param Person $person
     */
    protected function setSpeaker(Person $person)
    {

        $em = $this->getDoctrine()->getManager();

        if ($person->getIsSpeaker() && !$person->getSpeaker()) {
            $speaker = new Speaker($person);
            $em->persist($speaker);
        }

        if (!$person->getIsSpeaker() && $person->getSpeaker()) {
            $speaker = $person->getSpeaker();
            $em->remove($speaker);
        }

    }


    /**
     * Set a member
     * @param Person $person
     * @param Center $center
     */
    protected function setMember(Person $person, Center $center)
    {

        $em = $this->getDoctrine()->getManager();

        if ($person->getIsMember() && !$person->getMember()) {
            $member = new Member($person);
            $member->addCenter($center);
            $em->persist($member);
        }

        if ($person->getIsMember() && $person->getMember()) {
            //$member = $person->getMember();
            //$member->addCenter($center);
            //$em->persist($member);
        }

        if (!$person->getIsMember() && $person->getMember()) {
            $member = $person->getMember();
            $member->removeCenter($center);
            $em->persist($member);

            if ($member->getCenters()->count() == 0) {
                $em->remove($member);
            }
        }

    }

    /**
     * Set a visitor
     * @param Person $person
     * @param Center $center
     */
    protected function setVisitor(Person $person, Center $center)
    {

        $em = $this->getDoctrine()->getManager();

        if ($person->getIsVisitor() && !$person->getVisitor()) {
            $visitor = new Visitor($person);
            $visitor->addCenter($center);
            $em->persist($visitor);
        }

        if ($person->getIsVisitor() && $person->getVisitor()) {
            //$visitor = $person->getVisitor();
            //$visitor->addCenter($center);
            //$em->persist($visitor);
        }

        if (!$person->getIsVisitor() && $person->getVisitor()) {
            $visitor = $person->getVisitor();
            $visitor->removeCenter($center);
            $em->persist($visitor);

            if ($visitor->getCenters()->count() == 0) {
                $em->remove($visitor);
            }
        }


    }
}