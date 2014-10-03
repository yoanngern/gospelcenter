<?php

namespace gospelcenter\AdminBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuideController extends Controller {


    public function listAction(Center $center)
    {

        return $this->render(
            'gospelcenterAdminBundle:Guide:list.html.twig',
            array(
                'center' => $center,
                'page' => 'guides',
                'tab' => 'guides'
            )
        );
    }
}