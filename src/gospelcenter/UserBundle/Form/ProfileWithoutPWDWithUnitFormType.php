<?php

namespace gospelcenter\UserBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\UserBundle\Form\ProfileWithoutPWDFormType;

use gospelcenter\AccessBundle\Form\UnitType;

class ProfileWithoutPWDWithUnitFormType extends ProfileWithoutPWDFormType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('units',  'entity', array('class'     => 'gospelcenterAccessBundle:Unit',
                                                'property'  => 'name',
                                                'multiple'  => true,
                                                'required' 	=> true));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_userbundle_profilewithoutpwdwithunit';
    }
}
