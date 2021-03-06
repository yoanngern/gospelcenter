<?php

namespace gospelcenter\APIBundle\Controller;

use gospelcenter\CenterBundle\Entity\Center;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{


    /**
     * @return Response
     */
    public function getVideosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');
        $callback = $request->get('callback');
        $nb = $request->get('nb');
        $page = $request->get('page');

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithVideo($page, $nb);

        $customCelebrations = [];

        $twigSpeakers = $this->container->get('gospelcenter_celebration.speakers');
        $twigOneDate = $this->container->get('gospelcenter_date.dates');

        foreach ($celebrations as $celebration) {

            $customCelebration["id"] = $celebration->getId();

            $customCelebration["video_id"] = $celebration->getVideo()->getId();


            $customCelebration["link"] = $this->generateUrl(
                'gospelcenterMedia_video',
                array(
                    'video' => $celebration->getVideo()->getId()
                )
            );

            $customCelebration["action"] = "Regarder la vidéo";

            if ($celebration->getTitle() != "") {
                $customCelebration["subtitle"] = $celebration->getTitle();
            } else {
                $customCelebration["subtitle"] = $twigOneDate->oneDate($celebration->getDate(), $request->getLocale());
            }

            $customCelebration["title"] = $twigSpeakers->speakers($celebration, $request->getLocale());

            if ($celebration->getImage() !== null) {

                $customCelebration["has_image"] = true;

                $customCelebration["image"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall'
                );

                $customCelebration["image_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_2x'
                );

                $customCelebration["image_tablet"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet'
                );

                $customCelebration["image_tablet_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet_2x'
                );

                $customCelebration["image_mobile"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile'
                );

                $customCelebration["image_mobile_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile_2x'
                );
            } else {
                $customCelebration["has_image"] = false;
            }


            $customCelebrations[] = $customCelebration;

        }

        $array = [];
        $array["page"] = $page;
        $array["nb"] = $nb;
        $array["items"] = $customCelebrations;

        $response = new JsonResponse($array, 200, array('content-type' => 'application/json'));

        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setCallback($callback);

        return $response;
    }


    /**
     * @return Response
     */
    public function getAudiosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');
        $callback = $request->get('callback');
        $nb = $request->get('nb');
        $page = $request->get('page');

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithAudio($page, $nb);

        $customCelebrations = [];

        $twigSpeakers = $this->container->get('gospelcenter_celebration.speakers');
        $twigOneDate = $this->container->get('gospelcenter_date.dates');


        foreach ($celebrations as $celebration) {

            $customCelebration["id"] = $celebration->getId();

            $customCelebration["video_id"] = $celebration->getAudio()->getId();


            $customCelebration["link"] = $this->generateUrl(
                'gospelcenterMedia_audio',
                array(
                    'audio' => $celebration->getAudio()->getId()
                )
            );

            $customCelebration["action"] = "Ecouter";

            if ($celebration->getTitle() != "") {
                $customCelebration["subtitle"] = $celebration->getTitle();
            } else {
                $customCelebration["subtitle"] = $twigOneDate->oneDate($celebration->getDate(), $request->getLocale());
            }

            $customCelebration["title"] = $twigSpeakers->speakers($celebration, $request->getLocale());

            if ($celebration->getImage() !== null) {

                $customCelebration["has_image"] = true;

                $customCelebration["image"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall'
                );

                $customCelebration["image_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_2x'
                );

                $customCelebration["image_tablet"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet'
                );

                $customCelebration["image_tablet_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet_2x'
                );

                $customCelebration["image_mobile"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile'
                );

                $customCelebration["image_mobile_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile_2x'
                );
            } else {
                $customCelebration["has_image"] = false;
            }


            $customCelebrations[] = $customCelebration;

        }

        $array = [];
        $array["page"] = $page;
        $array["nb"] = $nb;
        $array["items"] = $customCelebrations;

        $response = new JsonResponse($array, 200, array('content-type' => 'application/json'));

        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setCallback($callback);

        return $response;
    }


    /**
     * @param Center $center
     * @return Response
     */
    public function getCenterAction(Center $center)
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');
        $callback = $request->get('callback');
        $nb = $request->get('nb');
        $page = $request->get('page');

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenterWithMedia($center, $page, $nb);

        $customCelebrations = [];

        $twigSpeakers = $this->container->get('gospelcenter_celebration.speakers');
        $twigOneDate = $this->container->get('gospelcenter_date.dates');

        foreach ($celebrations as $celebration) {

            //print($celebration->getId());

            $customCelebration["id"] = $celebration->getId();

            if ($celebration->getVideo()) {


                $customCelebration["video_id"] = $celebration->getVideo()->getId();


                $customCelebration["link"] = $this->generateUrl(
                    'gospelcenterMedia_video',
                    array(
                        'video' => $celebration->getVideo()->getId()
                    )
                );

                $customCelebration["action"] = "Regarder la vidéo";

            } elseif ($celebration->getAudio()) {

                $customCelebration["audio_id"] = $celebration->getAudio()->getId();


                $customCelebration["link"] = $this->generateUrl(
                    'gospelcenterMedia_audio',
                    array(
                        'audio' => $celebration->getAudio()->getId()
                    )
                );

                $customCelebration["action"] = "Ecouter";

            }

            if ($celebration->getTitle() != "") {
                $customCelebration["subtitle"] = $celebration->getTitle();
            } else {
                $customCelebration["subtitle"] = $twigOneDate->oneDate($celebration->getDate(), $request->getLocale());
            }

            $customCelebration["title"] = $twigSpeakers->speakers($celebration, $request->getLocale());

            if ($celebration->getImage() !== null) {

                $customCelebration["has_image"] = true;

                $customCelebration["image"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall'
                );

                $customCelebration["image_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_2x'
                );

                $customCelebration["image_tablet"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet'
                );

                $customCelebration["image_tablet_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_tablet_2x'
                );

                $customCelebration["image_mobile"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile'
                );

                $customCelebration["image_mobile_2x"] = $this->get('liip_imagine.cache.manager')->getBrowserPath(
                    $celebration->getImage()->getWebPath(),
                    'tv_wall_mobile_2x'
                );
            } else {
                $customCelebration["has_image"] = false;
            }


            $customCelebrations[] = $customCelebration;


        }

        $array = [];
        $array["page"] = $page;
        $array["nb"] = $nb;
        $array["items"] = $customCelebrations;

        $response = new JsonResponse($array, 200, array('content-type' => 'application/json'));

        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setCallback($callback);

        return $response;
    }

}