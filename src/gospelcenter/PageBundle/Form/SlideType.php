<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\ImageBundle\Form\ImageSimpleType;

class SlideType extends AbstractType
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
    
        $center = $this->center;
        
        $builder
            ->add('title',          'text')
            ->add('text',           'textarea')
            ->add('link',           'url', array('required' => false))
            ->add('labelLink',      'text', array('required' => false))
            ->add('image',          new ImageSimpleType(), array('required' => false))
            ->add('page',           'entity', array('class'         => 'gospelcenterPageBundle:Page',
                                                    'required'      => false,
                                                    'empty_value'   => 'Select a page',
                                                    'query_builder' => function(\gospelcenter\PageBundle\Entity\PageRepository $r) use ($center) {
                                                        return $r->getSelectList($center);},
                                                    'property' => 'title'))
        ;
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
        return 'gospelcenter_pagebundle_slide';
    }
}
