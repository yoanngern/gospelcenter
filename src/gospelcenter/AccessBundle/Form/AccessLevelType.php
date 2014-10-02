<?php

namespace gospelcenter\AccessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccessLevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'access',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Access',
                    ),
                    'class' => 'gospelcenterAccessBundle:Access',
                    'property' => 'service',
                    'required' => true,
                    'label' => false,
                    'multiple' => false
                )
            )
            ->add(
                'level',
                'choice',
                array(
                    'attr' => array(
                        'placeholder' => 'Level',
                    ),
                    'choices' => array(
                        'VIEW' => 'View',
                        'EDIT' => 'Edit',
                        'CREATE' => 'Create',
                        'DELETE' => 'Delete',
                        'MASTER' => 'Master'
                    ),
                    'required' => true,
                    'label' => false,
                    'multiple' => false,
                    'expanded' => false
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
                'data_class' => 'gospelcenter\AccessBundle\Entity\AccessLevel'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_accessbundle_accesslevel';
    }
}
