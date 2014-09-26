<?php

namespace gospelcenter\DateBundle\Twig\Extension;

use gospelcenter\DateBundle\Entity\Date;
use Twig_Extension;
use Twig_Filter_Method;

class HelperExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            'datetime' => new Twig_Filter_Method($this, 'datetime'),
            'dates' => new Twig_Filter_Method($this, 'dates'),
            'datesShort' => new Twig_Filter_Method($this, 'datesShort')
        );
    }

    public function datetime($d, $format = "%B %e, %Y %H:%M", $locale)
    {

        if ($d instanceof \DateTime) {
            $d = $d->getTimestamp();
        }


        setLocale(LC_TIME, $locale);

        return strftime($format, $d);
    }

    public function dates($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();
        $end = $date->getEnd()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {
                        $string = strftime("%e %b %Y - ", $start) . strftime("%e %b %Y", $end);
                    } else {
                        $string = strftime("%e %b - ", $start) . strftime("%e %b %Y", $end);
                    }

                } else {
                    $string = strftime("%e - ", $start) . strftime("%e %B %Y", $end);
                }
            } else {
                $string = strftime("%e %B %Y", $start);
            }

        } else {
            setLocale(LC_TIME, "en_US");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {

                        $string = strftime("%e %b %Y - ", $start) . strftime("%e %b %Y", $end);

                    } else {
                        $string = strftime("%b %e - ", $start) . strftime("%b %e, %Y", $end);
                    }

                } else {
                    $string = strftime("%B %e - ", $start) . strftime("%e, %Y", $end);
                }
            } else {
                $string = strftime("%B %e, %Y", $start);
            }
        }


        return $string;
    }

    public function datesShort($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();
        $end = $date->getEnd()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {
                        $string = strftime("%e %b %y - ", $start) . strftime("%e %b %y", $end);
                    } else {
                        $string = strftime("%e %b - ", $start) . strftime("%e %b %Y", $end);
                    }

                } else {
                    $string = strftime("%e - ", $start) . strftime("%e %b %Y", $end);
                }
            } else {
                $string = strftime("%e %b %Y", $start);
            }

        } else {
            setLocale(LC_TIME, "en_US");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {

                        $string = strftime("%e %b %y - ", $start) . strftime("%e %b %y", $end);

                    } else {
                        $string = strftime("%b %e - ", $start) . strftime("%b %e, %Y", $end);
                    }

                } else {
                    $string = strftime("%b %e - ", $start) . strftime("%e, %Y", $end);
                }
            } else {
                $string = strftime("%b %e, %Y", $start);
            }
        }


        return $string;
    }

    public function getName()
    {
        return 'Helper';
    }
}