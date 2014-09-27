<?php

namespace gospelcenter\PeopleBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonSimpleType extends PersonType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->remove('dateOfBirth');
        $builder->remove('email');
        $builder->remove('privatePhone');
        $builder->remove('mobilePhone');
        $builder->remove('notes');
        $builder->remove('language');
        $builder->remove('abroad');
        $builder->remove('hasChildren');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\PeopleBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_peoplebundle_personsimpletype';
    }
}
