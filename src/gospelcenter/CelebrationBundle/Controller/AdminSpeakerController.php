<?php

namespace gospelcenter\CelebrationBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CelebrationBundle\Form\SpeakerType;
use gospelcenter\PeopleBundle\Entity\Person;
use JMS\SecurityExtraBundle\Annotation\Secure;
use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminSpeakerController extends Controller {


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Center $center)
    {
        if (false === $this->get('security.context')->isGranted("VIEW", new Speaker(new Person()))) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllByCenter($center);
        
        return $this->render('gospelcenterAdminBundle:Speaker:list.html.twig', array(
            'center' => $center,
            'speakers' => $speakers,
            'page' => 'people',
            'tab' => 'speakers'
        ));
    }


    /**
     * @Secure(roles="ROLE_USER")
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllOrder();

        if (false === $this->get('security.context')->isGranted("VIEW", $speakers[0])) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        return $this->render('gospelcenterAdminBundle:Speaker:list.html.twig', array(
            'center' => $center,
            'speakers' => $speakers,
            'page' => 'people',
            'tab' => 'speakersAll'
        ));
    }
}