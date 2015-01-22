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
            'datesShort' => new Twig_Filter_Method($this, 'datesShort'),
            'month' => new Twig_Filter_Method($this, 'month'),
            'oneDate' => new Twig_Filter_Method($this, 'oneDate'),
            'oneDate_short' => new Twig_Filter_Method($this, 'oneDate_short'),
            'oneDate_mini' => new Twig_Filter_Method($this, 'oneDate_mini'),
            'times' => new Twig_Filter_Method($this, 'times'),
            'startTime' => new Twig_Filter_Method($this, 'startTime')
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
            setLocale(LC_TIME, "fr_FR.UTF8");

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
            setLocale(LC_TIME, "fr_FR.UTF8");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {
                        $string = strftime("%e %b %y - ", $start) . strftime("%e %b %y", $end);
                    } else {
                        $string = strftime("%e %b - ", $start) . strftime("%e %b", $end);
                    }

                } else {
                    $string = strftime("%e - ", $start) . strftime("%e %B", $end);
                }
            } else {
                $string = strftime("%e %B", $start);
            }

        } else {
            setLocale(LC_TIME, "en_US");

            if (strftime("%d%m%Y", $start) != strftime("%d%m%Y", $end)) {

                if (strftime("%m%Y", $start) != strftime("%m%Y", $end)) {

                    if (strftime("%Y", $start) != strftime("%Y", $end)) {

                        $string = strftime("%e %b %y - ", $start) . strftime("%e %b %y", $end);

                    } else {
                        $string = strftime("%b %e - ", $start) . strftime("%b %e", $end);
                    }

                } else {
                    $string = strftime("%B %e - ", $start) . strftime("%e", $end);
                }
            } else {
                $string = strftime("%B %e", $start);
            }
        }


        return $string;
    }


    public function month($date, $locale)
    {

        $string = "";

        $date = $date->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%B", $date);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%B", $date);
        }

        return $string;
    }


    public function oneDate($date, $locale)
    {

        $string = "";


        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%e %B %Y", $start);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%B %e, %Y", $start);
        }

        return $string;
    }


    public function oneDate_short($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%e %B", $start);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%B %e", $start);
        }

        return $string;
    }


    public function oneDate_mini($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%e/%m/%Y", $start);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%m/%e/%Y", $start);
        }

        return $string;
    }


    public function times($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();
        $end = $date->getEnd()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%k:%M", $start) . " - " . strftime("%k:%M", $end);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%l:%M %p", $start) . " - " . strftime("%l:%M %p", $end);
        }

        return $string;
    }


    public function startTime($date, $locale)
    {

        $string = "";

        if (!$date instanceof Date) {
            return "";
        }

        $start = $date->getStart()->getTimestamp();


        if ($locale == 'fr') {
            setLocale(LC_TIME, "fr_FR.UTF8");

            $string = strftime("%k:%M", $start);


        } else {
            setLocale(LC_TIME, "en_US");

            $string = strftime("%l:%M %p", $start);
        }

        return $string;
    }


    public function getName()
    {
        return 'Helper';
    }
}