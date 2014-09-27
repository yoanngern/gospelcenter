<?php

namespace gospelcenter\CelebrationBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\PeopleBundle\Form\RoleType;


class CelebrationMobileType extends CelebrationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->remove('date')
            ->add('date',       'date', array('widget' => 'single_text'))
        
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\CelebrationBundle\Entity\Celebration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_celebrationbundle_celebrationmobiletype';
    }
}
