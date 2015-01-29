<?php

namespace gospelcenter\LocationBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\LocationBundle\Entity\Location;
use gospelcenter\LocationBundle\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class GeoController extends Controller
{

    /**
     * List of all locations
     * @param Center $center
     * @return Response
     */
    public function OneJsonAction(Center $center)
    {

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


}