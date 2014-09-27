<?php

namespace gospelcenter\PeopleBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\UserBundle\Form\ProfileWithoutPWDWithUnitFormType;

class PersonWithAccountType extends PersonType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->remove('user');
        $builder->add('user', new ProfileWithoutPWDWithUnitFormType('gospelcenter\UserBundle\Entity\User'), array('required' => false));
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
        return 'gospelcenter_peoplebundle_personwithaccounttype';
    }
}
