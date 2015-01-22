<?php

namespace gospelcenter\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class SpeakerController extends Controller
{

    /**
     * @return Response
     */
    public function getSpeakersAction()
    {
        $em = $this->getDoctrine()->getManager();

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


        $request = $this->get('request');
        $callback = $request->get('callback');

        $response = new JsonResponse($speakersCustom, 200, array('content-type' => 'application/json'));
        $response->setCallback($callback);
        return $response;
    }


    /**
     * @param $speaker
     * @return Response
     */
    public function getSpeakerAction($speaker)
    {
        $em = $this->getDoctrine()->getManager();
        //$request = $this->get('request');

        //$centerId = $request->query->get('center');
        //$center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);

        $speaker = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findOne($speaker);

        $response = new Response(json_encode($speaker));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}