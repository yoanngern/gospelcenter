<?php

namespace gospelcenter\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add(
                'address1',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Address 1',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'address2',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Address 2',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'postalCode',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Postal code',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'city',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'City',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'country',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Country',
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
                'data_class' => 'gospelcenter\LocationBundle\Entity\Location'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_locationbundle_location';
    }
}
