<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class YouthPageType extends PageType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->remove('ref');
        $builder->remove('template');
        $builder->add('sort',   'choice', array(
                                    'choices'   => array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'),  
                                    'multiple'  => false,
                                    'empty_value'   => 'Select a level',));
        $builder->add('alias',  'text', array('required' => false));
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
        return 'gospelcenter_pagebundle_youthpagetype';
    }
}
