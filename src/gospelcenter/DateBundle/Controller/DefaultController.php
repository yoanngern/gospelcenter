<?php

namespace gospelcenter\DateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('gospelcenterDateBundle:Default:index.html.twig', array('name' => $name));
    }
}
