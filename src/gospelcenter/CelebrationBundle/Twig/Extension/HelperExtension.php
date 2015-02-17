<?php

namespace gospelcenter\CelebrationBundle\Twig\Extension;

use gospelcenter\CelebrationBundle\Entity\Celebration;
use Twig_Extension;
use Twig_Filter_Method;

class HelperExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            'speakers' => new Twig_Filter_Method($this, 'speakers'),
        );
    }

    public function speakers($celebration, $locale)
    {

        $string = "";

        if (!$celebration instanceof Celebration) {
            return "";
        }

        if ($locale == 'fr') {
            $and = " et ";
        } else {
            $and = " and ";
        }

        $speakers = $celebration->getSpeakers();

        foreach($speakers as $key => $speaker) {

            $person = $speaker->getPerson();

            if($key != 0 && $key != (sizeof($speakers) - 1)) {
                $string .= ", ";
            } elseif($key != 0 && $key == (sizeof($speakers) - 1)) {
                $string .= $and;
            }

            $string .= $person->getFirstname() . " " . $person->getLastname();
        }

        return $string;
    }


    public function getName()
    {
        return 'CelebrationHelper';
    }
}