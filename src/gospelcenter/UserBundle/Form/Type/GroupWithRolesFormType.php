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

use FOS\UserBundle\Form\Type\GroupFormType;

class GroupWithRolesFormType extends GroupFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('localRoles',           'choice', array(
                                        'choices'   => array(
                                            'ROLE_LOCAL'   => 'ROLE_LOCAL',
                                            'Center'        => 'Center',
                                            'Slide'         => 'Slide',
                                            'Person'        => 'Person',
                                            'Event'         => 'Event'
                                        ),  
                                        'multiple'  => true,
                                        'empty_value'   => 'Select a role',));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\UserBundle\Entity\Unit',
            'intention'  => 'group',
        ));
    }

    public function getName()
    {
        return 'gospelcenter_userbundle_groupwithrolesformtype';
    }
}
