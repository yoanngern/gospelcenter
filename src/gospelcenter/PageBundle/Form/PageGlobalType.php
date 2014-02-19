<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageGlobalType extends PageType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->remove('ref');
        $builder->add('ref',            'choice', array(
                                        'choices'   => array(
                                            'celebrations'  => 'Celebrations',
                                            'vision'        => 'Vision',
                                            'training'      => 'Training'
                                        ),
                                        'multiple'  => false,
                                        'empty_value'   => 'Select a menu'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\PageBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_pagebundle_pageglobaltype';
    }
}
