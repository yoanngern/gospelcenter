<?php

namespace gospelcenter\AccessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\AccessBundle\Form\AccessLevelType;

class UnitType extends AbstractType
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
                        'placeholder' => 'Title',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )

            ->add(
                'accessLevels',
                'collection',
                array(
                    'attr' => array(
                        'class' => 'collection accessesLevel',
                        'data-add' => 'Add another access',
                        'data-add_first' => 'Add an access',
                        'data-remove' => 'Remove this access',
                        'data-label' => 'Access'
                    ),
                    'required' => false,
                    'type' => new AccessLevelType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\AccessBundle\Entity\Unit'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_accessbundle_unit';
    }
}
