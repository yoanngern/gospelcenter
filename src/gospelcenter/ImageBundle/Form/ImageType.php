<?php

namespace gospelcenter\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          'text')
            ->add('file',           'file')
            ->add('type',           'choice', array(
                                        'choices'   => array(
                                            'Celebration'   => 'Celebration',
                                            'Center'        => 'Center',
                                            'Slide'         => 'Slide',
                                            'Person'        => 'Person',
                                            'Event'         => 'Event'
                                        ),  
                                        'multiple'  => false,
                                        'empty_value'   => 'Select a type',))
            ->add('description',    'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\ImageBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_imagebundle_image';
    }
}
