<?php

namespace gospelcenter\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Center
use gospelcenter\CenterBundle\Entity\Center;

// Speaker
use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CelebrationBundle\Form\SpeakerType;

class SpeakerController extends Controller
{

    /**
     *  GET - list all speakers
     */
    public function getSpeakersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        //$centerId = $request->query->get('center');
        //$center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);

        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllJSON();

        $speakersCustom = array();

        foreach ($speakers as $speaker) {

            if($speaker["image_id"] != null) {
                $image = $em->getRepository('gospelcenterImageBundle:Image')->find($speaker["image_id"]);

                $speaker["image_url"] = "/" . $image->getWebPath();

            } else {
                $speaker["image_url"] = null;
            }

            unset($speaker["image_id"]);

            $speakersCustom[] = $speaker;
        }



        $response = new Response(json_encode($speakersCustom));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     *  GET - get speaker details
     */
    public function getSpeakerAction($speaker)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $centerId = $request->query->get('center');
        $center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);

        $speaker = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findOne($speaker);

        $response = new Response(json_encode($speaker));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}