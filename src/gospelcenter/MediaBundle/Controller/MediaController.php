<?php

namespace gospelcenter\MediaBundle\Controller;

use gospelcenter\CelebrationBundle\Entity\Speaker;
use gospelcenter\CenterBundle\Entity\Center;
use gospelcenter\MediaBundle\Entity\Audio;
use gospelcenter\MediaBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaController extends Controller
{

    public function closeAction()
    {


        if(true) {
            throw $this->createNotFoundException('The Gospel Center TV is closed!');

        }


    }


    /**
     * Home
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllLast(4);

        return $this->render(
            'gospelcenterMediaBundle:Media:home.html.twig',
            array(
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("selections"),
                'previousLabel' => $this->previousLabel('Selection'),
                'page' => 'selections'
            )
        );
    }


    /**
     * All Speakers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function speakersAction()
    {

        $em = $this->getDoctrine()->getManager();

        $speakers = $em->getRepository('gospelcenterCelebrationBundle:Speaker')->findAllWithMedia();

        return $this->render(
            'gospelcenterMediaBundle:Media:speakers.html.twig',
            array(
                'speakers' => $speakers,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("speakers"),
                'previousLabel' => $this->previousLabel('Speakers'),
                'page' => 'speakers'
            )
        );
    }


    /**
     * All videos of a speaker
     * @param Speaker $speaker
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function speakerAction(Speaker $speaker)
    {

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllBySpeakerWithMedia(
            $speaker
        );

        return $this->render(
            'gospelcenterMediaBundle:Media:speaker.html.twig',
            array(
                'speaker' => $speaker,
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("speakers"),
                'previousLabel' => $this->previousLabel(
                    $speaker->getPerson()->getFirstname() . " " . $speaker->getPerson()->getLastname()
                ),
                'page' => 'speakers'
            )
        );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function videosAction()
    {

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithVideo(1, 8);

        return $this->render(
            'gospelcenterMediaBundle:Media:videos.html.twig',
            array(
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("videos"),
                'previousLabel' => $this->previousLabel('Videos'),
                'page' => 'videos'
            )
        );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function audiosAction()
    {

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllWithAudio(1, 8);

        return $this->render(
            'gospelcenterMediaBundle:Media:audios.html.twig',
            array(
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("audios"),
                'previousLabel' => $this->previousLabel('Audios'),
                'page' => 'audios'
            )
        );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function centersAction()
    {

        $em = $this->getDoctrine()->getManager();

        $centers = $em->getRepository('gospelcenterCenterBundle:Center')->findAllWithMedia();

        return $this->render(
            'gospelcenterMediaBundle:Media:centers.html.twig',
            array(
                'centers' => $centers,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("centers"),
                'previousLabel' => $this->previousLabel('Cities'),
                'page' => 'centers'
            )
        );
    }


    /**
     * @param Center $center
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function centerAction(Center $center)
    {

        $em = $this->getDoctrine()->getManager();

        $celebrations = $em->getRepository('gospelcenterCelebrationBundle:Celebration')->findAllByCenterWithMedia(
            $center, 1, 8
        );

        return $this->render(
            'gospelcenterMediaBundle:Media:center.html.twig',
            array(
                'center' => $center,
                'celebrations' => $celebrations,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag("centers"),
                'previousLabel' => $this->previousLabel("Gospel Center " . $center->getName()),
                'page' => 'centers'
            )
        );
    }


    /**
     * @param Video $video
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function videoAction(Video $video)
    {
        $em = $this->getDoctrine()->getManager();

        $speakers = Array();

        foreach($video->getCelebration()->getSpeakers() as $speaker) {
            $speakers[] = $speaker->getPerson()->getId();
        }

        $videos = $em->getRepository('gospelcenterMediaBundle:Video')->findVideosSameSpeaker($video, $speakers);

        return $this->render(
            'gospelcenterMediaBundle:Media:video.html.twig',
            array(
                'video' => $video,
                'videos' => $videos,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag(),
                'previousLabel' => $this->previousLabel($video->getCelebration()->getTitle()),
                'page' => $this->previousTag()
            )
        );
    }


    /**
     * @param Audio $audio
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function audioAction(Audio $audio)
    {

        $em = $this->getDoctrine()->getManager();

        $speakers = Array();

        foreach($audio->getCelebration()->getSpeakers() as $speaker) {
            $speakers[] = $speaker->getPerson()->getId();
        }

        $audios = $em->getRepository('gospelcenterMediaBundle:Audio')->findAudiosSameSpeaker($audio, $speakers);

        return $this->render(
            'gospelcenterMediaBundle:Media:audio.html.twig',
            array(
                'audio' => $audio,
                'audios' => $audios,
                'previousUrl' => $this->previousUrl(),
                'previousTag' => $this->previousTag(),
                'previousLabel' => $this->previousLabel($audio->getCelebration()->getTitle()),
                'page' => $this->previousTag()
            )
        );
    }


    /**
     * @return null
     */
    private function previousUrl()
    {
        $session = $this->get('session');

        if ($session->get('previousUrl') != null) {
            $previousUrl = $session->get('previousUrl');
        } else {
            $previousUrl = null;
        }

        $currentUrl = $this->get('request')->server->get('HTTP_REFERER');
        $session->set('previousUrl', $currentUrl);

        return $previousUrl;
    }


    /**
     * @param null $currentTag
     * @return null
     */
    private function previousTag($currentTag = null)
    {
        $session = $this->get('session');

        if ($session->get('previousTag') != null) {
            $previousTag = $session->get('previousTag');
        } else {
            $previousTag = null;
        }

        if ($currentTag == null) {
            $currentTag = $previousTag;
        }

        $session->set('previousTag', $currentTag);

        return $previousTag;
    }


    /**
     * @param null $currentLabel
     * @return null
     */
    private function previousLabel($currentLabel = null)
    {
        $session = $this->get('session');

        if ($session->get('previousLabel') != null) {
            $previousLabel = $session->get('previousLabel');
        } else {
            $previousLabel = null;
        }

        if ($currentLabel == null) {
            $currentLabel = $previousLabel;
        }

        $session->set('previousLabel', $currentLabel);

        return $previousLabel;
    }

}
