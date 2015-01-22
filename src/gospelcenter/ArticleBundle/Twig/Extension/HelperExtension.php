<?php

namespace gospelcenter\ArticleBundle\Twig\Extension;

use Twig_Extension;
use Twig_Filter_Method;

class HelperExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            'isexternal' => new Twig_Filter_Method($this, 'isexternal')
        );
    }

    public function isexternal($url, $other)
    {

        if (strpos($url, "/") === 0
            || stristr($url, 'gospel-center.com') !== false
            || stristr($url, 'gospel-center.org') !== false
            || stristr($url, 'gc-lausanne.org') !== false
            || stristr($url, 'gc-montreux.org') !== false
            || stristr($url, 'gc-annecy.org') !== false
            || stristr($url, 'gc-jura.org') !== false
        ) {
            return false;
        } else {
            return true;
        }
    }


    public function getName()
    {
        return 'url_helper';
    }
}