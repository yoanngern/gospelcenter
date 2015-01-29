<?php

namespace gospelcenter\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{


    /**
     * @return Response
     */
    public function getLocationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        //$centerId = $request->query->get('center');
        //$center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);

        $locations = $em->getRepository('gospelcenterLocationBundle:Location')->findAllJSON();

        $response = new Response(json_encode($locations));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @param $location
     * @return Response
     */
    public function getLocationAction($location)
    {
        $em = $this->getDoctrine()->getManager();
        //$request = $this->get('request');

        //$centerId = $request->query->get('center');
        //$center = $em->getRepository('gospelcenterCenterBundle:Center')->findByRef($centerId);

        $location = $em->getRepository('gospelcenterLocationBundle:Location')->findOne($location);

        $response = new Response(json_encode($location));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param $location
     * @return Response
     */
    public function getLocationGeoAction($location)
    {
        $em = $this->getDoctrine()->getManager();

        $location = $em->getRepository('gospelcenterLocationBundle:Location')->findOneJSON($location);

        $map["type"] = "FeatureCollection";

        $feature["type"] = "Feature";
        $feature["properties"]["name"] = $location["name"];
        $feature["properties"]["address1"] = $location["address1"];
        $feature["properties"]["address2"] = $location["address2"];
        $feature["properties"]["postalCode"] = $location["postalCode"];
        $feature["properties"]["country"] = $location["country"];
        $feature["geometry"]["type"] = "Point";
        $feature["geometry"]["coordinates"][] = $location["latitude"];;
        $feature["geometry"]["coordinates"][] = $location["longitude"];;

        $map["features"][] = $feature;

        $response = new Response(json_encode($map));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}