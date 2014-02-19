<?php

namespace gospelcenter\CenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MemberType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',      'text')
            ->add('lastname',       'text')
            ->add('gender', 'choice', array(
                        'choices'   => array(
                            'man'   => 'Man',
                            'woman' => 'Woman',
                        ),
                        'multiple'  => false,
                    ))
            ->add('dateOfBirth',     'birthday', array('required' => false))
            ->add('email',          'email', array('required' => false))
            ->add('privatePhone',   'text', array('required' => false))
            ->add('mobilePhone',    'text', array('required' => false))
            ->add('memberFromDate', 'date')
            ->add('description',    'textarea', array('required' => false))
            ->add('language',       'language')
            ->add('abroad',         'checkbox', array('required' => false))
            ->add('hasChildren',    'checkbox', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\CenterBundle\Entity\Member'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_centerbundle_member';
    }
}
