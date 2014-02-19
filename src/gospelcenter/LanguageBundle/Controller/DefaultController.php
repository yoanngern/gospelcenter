<?php

namespace gospelcenter\LanguageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('gospelcenterLanguageBundle:Default:index.html.twig', array('name' => $name));
    }
}
