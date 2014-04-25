<?php

namespace gospelcenter\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class gospelcenterUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
