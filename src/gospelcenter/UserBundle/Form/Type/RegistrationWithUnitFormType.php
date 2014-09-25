<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace gospelcenter\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\UserBundle\Form\Type\RegistrationFormType;

use gospelcenter\AccessBundle\Form\UnitType;

class RegistrationWithUnitFormType extends RegistrationFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('units',  'entity', array('class'     => 'gospelcenterAccessBundle:Unit',
                                                'property'  => 'name',
                                                'multiple'  => true,
                                                'required' 	=> false));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\UserBundle\Entity\User',
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'gospelcenter_userbundle_registrationwithunitformtype';
    }
}
