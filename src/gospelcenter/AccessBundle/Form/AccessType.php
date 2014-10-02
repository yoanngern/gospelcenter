<?php

namespace gospelcenter\AccessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccessType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'service',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Service',
                    ),
                    'required' => true,
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
                'data_class' => 'gospelcenter\AccessBundle\Entity\Access'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_accessbundle_access';
    }
}
