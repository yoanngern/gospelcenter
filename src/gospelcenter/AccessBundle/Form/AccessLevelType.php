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
            ->add('level',  'choice', array('choices'   => array(
                                                'VIEW'      => 'View',
                                                'EDIT'      => 'Edit',
                                                'CREATE'    => 'Create',
                                                'DELETE'    => 'Delete',
                                                'UNDELETE'  => 'Undelete',
                                                'OPERATOR'  => 'Operator',
                                                'MASTER'    => 'Master'
                                            ),
                                            'multiple'  => true,
                                            'expanded'  => false))
            ->add('access',  'entity', array('class'     => 'gospelcenterAccessBundle:Access',
                                            'property'  => 'service',
                                            'multiple'  => false,
                                            'required' 	=> true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\AccessBundle\Entity\AccessLevel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_accessbundle_accesslevel';
    }
}
