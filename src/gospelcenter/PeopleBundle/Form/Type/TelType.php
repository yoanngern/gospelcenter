<?php

namespace gospelcenter\PeopleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TelType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'tel';
    }
}