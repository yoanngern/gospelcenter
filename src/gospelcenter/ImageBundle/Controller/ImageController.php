<?php

namespace gospelcenter\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// Image
use gospelcenter\ImageBundle\Entity\Image;


class ImageController extends Controller
{

    /**
     * @param Image $image
     * @return Response
     */
    public function imageAction(Image $image)
    {

        return $this->render(
            'gospelcenterImageBundle:Image:image.html.twig',
            array(
                'image' => $image
            )
        );
    }

    /**
     * @param Image $image
     * @return Response
     */
    public function imageUrlAction(Image $image)
    {

        return $this->render(
            'gospelcenterImageBundle:Image:imageUrl.html.twig',
            array(
                'image' => $image
            )
        );
    }


}