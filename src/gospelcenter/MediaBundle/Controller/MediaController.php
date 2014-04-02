<?php

namespace gospelcenter\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use gospelcenter\MediaBundle\Entity\Video;
use gospelcenter\CelebrationBundle\Entity\Speaker;

class MediaController extends Controller
{
    
    /*
    *   Home
    *
    */
    public function homeAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $starsVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findStarVideo(4);
        $lastVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findLastVideo(4);
        
        return $this->render('gospelcenterMediaBundle:Media:home.html.twig', array(
            'starsVideos' => $starsVideos,
            'lastVideos' => $lastVideos,
            'page' => 'selections'
        ));
    }
    
    
    /*
    *   All Speakers
    *
    */
    public function speakersAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllWithVideo();
        
        return $this->render('gospelcenterMediaBundle:Media:speakers.html.twig', array(
            'speakers' => $speakers,
            'page' => 'speakers'
        ));
    }
    
    
    /*
    *   All videos of a speaker
    *
    */
    public function speakerAction(Speaker $speaker)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllBySpeakerWithVideo($speaker);
        
        return $this->render('gospelcenterMediaBundle:Media:speaker.html.twig', array(
            'speaker' => $speaker,
            'celebrations' => $celebrations,
            'page' => 'speakers'
        ));
    }
    
    /*
    *   All Videos
    *
    */
    public function videosAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithVideo();
        
        return $this->render('gospelcenterMediaBundle:Media:videos.html.twig', array(
            'celebrations' => $celebrations,
            'page' => 'videos'
        ));
    }
    
    
    /*
    *   One video
    *
    */
    public function videoAction(Video $video)
    {
        
        return $this->render('gospelcenterMediaBundle:Media:video.html.twig', array(
            'video' => $video,
            'page' => 'selections'
        ));
    }

}
