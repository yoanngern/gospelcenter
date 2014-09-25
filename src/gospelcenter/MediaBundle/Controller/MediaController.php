<?php

namespace gospelcenter\MediaBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\MediaBundle\Entity\Audio;
use gospelcenter\MediaBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaController extends Controller
{

    /**
     * Home
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $starsVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findStarVideo(4);
        $lastVideos = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findLastVideo(4);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:home.html.twig', array(
                'starsVideos' => $starsVideos,
                'lastVideos' => $lastVideos,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("selections"),
                'previousLabel' => $this->previousLabel('Selection'),
                'page' => 'selections'
            ));  
        }
        
        return $this->render('gospelcenterMediaBundle:Media:home.html.twig', array(
            'starsVideos' => $starsVideos,
            'lastVideos' => $lastVideos,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("selections"),
            'previousLabel' => $this->previousLabel('Selection'),
            'page' => 'selections'
        ));
    }


    /**
     * All Speakers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function speakersAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllWithMedia();
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:speakers.html.twig', array(
                'speakers' => $speakers,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("speakers"),
                'previousLabel' => $this->previousLabel('Speakers'),
                'page' => 'speakers'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:speakers.html.twig', array(
            'speakers' => $speakers,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("speakers"),
            'previousLabel' => $this->previousLabel('Speakers'),
            'page' => 'speakers'
        ));
    }


    /**
     * All videos of a speaker
     * @param Speaker $speaker
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function speakerAction(Speaker $speaker)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllBySpeakerWithMedia($speaker);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:speaker.html.twig', array(
                'speaker' => $speaker,
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("speakers"),
                'previousLabel' => $this->previousLabel($speaker->getPerson()->getFirstname()." ".$speaker->getPerson()->getLastname()),
                'page' => 'speakers'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:speaker.html.twig', array(
            'speaker' => $speaker,
            'celebrations' => $celebrations,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("speakers"),
            'previousLabel' => $this->previousLabel($speaker->getPerson()->getFirstname()." ".$speaker->getPerson()->getLastname()),
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
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:videos.html.twig', array(
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("videos"),
                'previousLabel' => $this->previousLabel('Videos'),
                'page' => 'videos'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:videos.html.twig', array(
            'celebrations' => $celebrations,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("videos"),
            'previousLabel' => $this->previousLabel('Videos'),
            'page' => 'videos'
        ));
    }
    
    
    /*
    *   All Audios
    *
    */
    public function audiosAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithAudio();
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:audios.html.twig', array(
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("audios"),
                'previousLabel' => $this->previousLabel('Audios'),
                'page' => 'audios'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:audios.html.twig', array(
            'celebrations' => $celebrations,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("audios"),
            'previousLabel' => $this->previousLabel('Audios'),
            'page' => 'audios'
        ));
    }
    
    /*
    *   All centers
    *
    */
    public function centersAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $centers = $em->getRepository('gospelcenterCenterBundle:Center')->findAllWithMedia();
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:centers.html.twig', array(
                'centers' => $centers,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("centers"),
                'previousLabel' => $this->previousLabel('Cities'),
                'page' => 'centers'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:centers.html.twig', array(
            'centers' => $centers,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("centers"),
            'previousLabel' => $this->previousLabel('Cities'),
            'page' => 'centers'
        ));
    }
    
    
    /*
    *   One center
    *
    */
    public function centerAction(Center $center)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenterWithMedia($center);
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:center.html.twig', array(
                'center' => $center,
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("centers"),
                'previousLabel' => $this->previousLabel("Gospel Center ".$center->getName()),
                'page' => 'centers'
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:center.html.twig', array(
            'center' => $center,
            'celebrations' => $celebrations,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag("centers"),
            'previousLabel' => $this->previousLabel("Gospel Center ".$center->getName()),
            'page' => 'centers'
        ));
    }
    
    
    /*
    *   One video
    *
    */
    public function videoAction(Video $video)
    {
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:video.html.twig', array(
                'video' => $video,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag(),
                'previousLabel' => $this->previousLabel($video->getCelebration()->getTitle()),
                'page' => $this->previousTag()
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:video.html.twig', array(
            'video' => $video,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag(),
            'previousLabel' => $this->previousLabel($video->getCelebration()->getTitle()),
            'page' => $this->previousTag()
        ));
    }
    
   /*
    *   One audio
    *
    */
    public function audioAction(Audio $audio)
    {
        
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        if($mobileDetector->isMobile()) {
            return $this->render('gospelcenterMediaBundle:Mobile:audio.html.twig', array(
                'audio' => $audio,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag(),
                'previousLabel' => $this->previousLabel($audio->getCelebration()->getTitle()),
                'page' => $this->previousTag()
            ));
 
        }
        
        return $this->render('gospelcenterMediaBundle:Media:audio.html.twig', array(
            'audio' => $audio,
            'previousUrl' => $this->previousUrl(),
            'previousTag' => $this->previousTag(),
            'previousLabel' => $this->previousLabel($audio->getCelebration()->getTitle()),
            'page' => $this->previousTag()
        ));
    }


   /*
    *   Previous URL
    *   @return previousUrl
    */
    private function previousUrl() {
        $session = $this->get('session');
        
        if($session->get('previousUrl') != null) {
            $previousUrl = $session->get('previousUrl');
        } else {
            $previousUrl = null;
        }
        
        $currentUrl = $this->get('request')->server->get('HTTP_REFERER');
        $session->set('previousUrl', $currentUrl);
        
        return $previousUrl;
    }
    
    
   /*
    *   Previous tag
    *   @param currentTag
    *   @return previousTag
    */
    private function previousTag($currentTag = null) {
        $session = $this->get('session');
        
        if($session->get('previousTag') != null) {
            $previousTag = $session->get('previousTag');
        } else {
            $previousTag = null;
        }
        
        if($currentTag == null) {
            $currentTag = $previousTag;
        }
        
        $session->set('previousTag', $currentTag);
        
        return $previousTag;
    }
    
    
   /*
    *   Previous label
    *   @param currentLabel
    *   @return previousLabel
    */
    private function previousLabel($currentLabel = null) {
        $session = $this->get('session');
        
        if($session->get('previousLabel') != null) {
            $previousLabel = $session->get('previousLabel');
        } else {
            $previousLabel = null;
        }
        
        if($currentLabel == null) {
            $currentLabel = $previousLabel;
        }
        
        $session->set('previousLabel', $currentLabel);
        
        return $previousLabel;
    }

}
