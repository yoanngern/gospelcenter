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
                        'placeholder' => 'gc.admin.location.name',
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
                        'placeholder' => 'gc.admin.location.address1',
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
                        'placeholder' => 'gc.admin.location.address2',
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
                        'placeholder' => 'gc.admin.location.postal_code',
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
                        'placeholder' => 'gc.admin.location.city',
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
                        'placeholder' => 'gc.admin.location.country',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )->add(
                'latitude',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'gc.admin.location.latitude',
                        'data-geo' => 'lat'
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'longitude',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'gc.admin.location.longitude',
                        'data-geo' => 'long'
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
