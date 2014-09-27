<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SlideSimpleType extends SlideType
{
    
    public function __construct($options = null) {
        $this->center = $options;
    }
       
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        parent::buildForm($builder, $options);
        
        $builder->remove('title');
        $builder->remove('text');
        $builder->remove('link');
        $builder->remove('image');
        $builder->remove('link');
        $builder->remove('labelLink');
        $builder->remove('page');
        $builder->add('sort', 'number');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\PageBundle\Entity\Slide'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_pagebundle_slidesimpletype';
    }
}
