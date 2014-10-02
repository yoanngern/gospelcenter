<?php

namespace gospelcenter\CenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// FormType
use gospelcenter\LocationBundle\Form\LocationSimpleType;
use gospelcenter\ImageBundle\Form\ImageSimpleType;

class CenterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'ref',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Ref',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Name',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add('location', new LocationSimpleType(), array('required' => false))
            ->add('image', new ImageSimpleType(), array('required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\CenterBundle\Entity\Center'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_centerbundle_center';
    }
}
