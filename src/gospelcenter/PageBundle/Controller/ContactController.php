<?php

namespace gospelcenter\PageBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Center $center)
    {

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $txt = $request->request->get('message');

            $message = \Swift_Message::newInstance()
                ->setSubject('www.gc-'. $center->getRef() .'.org - Formulaire de contact')
                ->setFrom($email)
                ->setTo('web_contact@gc-'. $center->getRef() .'.org')
                ->setBody(
                    $this->renderView(
                        'gospelcenterPageBundle:Mail:contact.html.twig',
                        array(
                            'center' => $center,
                            'title' => 'Formulaire de contact',
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'message' => $txt
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            return $this->render(
                'gospelcenterPageBundle:Mail:thanks.html.twig',
                array(
                    'center' => $center,
                    'page' => 'contact'
                )
            );
        }

        return $this->redirect(
            $this->generateUrl(
                'gospelcenterContact',
                array(
                    'center' => $center->getRef(), 'domain' => $center->getDomain()
                )
            )
        );
    }


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function basesAction(Center $center)
    {

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $txt = $request->request->get('message');

            $message = \Swift_Message::newInstance()
                ->setSubject('www.gc-'. $center->getRef() .'.org - Les Bases - Formulaire de contact')
                ->setFrom($email)
                ->setTo('web_bases@gc-'. $center->getRef() .'.org')
                ->setBody(
                    $this->renderView(
                        'gospelcenterPageBundle:Mail:contact.html.twig',
                        array(
                            'center' => $center,
                            'title' => 'Les Bases - Formulaire de contact',
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'message' => $txt
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            return $this->render(
                'gospelcenterPageBundle:Mail:thanks.html.twig',
                array(
                    'center' => $center,
                    'page' => 'bases'
                )
            );
        }

        return $this->redirect(
            $this->generateUrl(
                'gospelcenterContact',
                array(
                    'center' => $center->getRef(), 'domain' => $center->getDomain()
                )
            )
        );
    }


    public function contactTestAction(Center $center)
    {

        return $this->render(
            'gospelcenterPageBundle:Mail:contact.html.twig',
            array(
                'center' => $center,
                'title' => 'Formulaire de contact',
                'name' => 'Yoann',
                'email' => 'yoann@yoanngern.ch',
                'phone' => '077 444 19 01',
                'message' => 'Hello! Every body'
            )
        );
    }

}
