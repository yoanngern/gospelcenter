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
            ->add(
                'title',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Title',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add('file', 'file')
            ->add(
                'type',
                'choice',
                array(
                    'attr' => array(
                        'placeholder' => 'Name',
                    ),
                    'choices' => array(
                        'Celebration' => 'Celebration',
                        'Center' => 'Center',
                        'Slide' => 'Slide',
                        'Person' => 'Person',
                        'Event' => 'Event'
                    ),
                    'multiple' => false,
                    'required' => true,
                    'label' => false,
                    'empty_value' => 'Select a type',
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'attr' => array(
                        'placeholder' => 'Description',
                    ),
                    'required' => false,
                    'label' => false,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\ImageBundle\Entity\Image'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_imagebundle_image';
    }
}
