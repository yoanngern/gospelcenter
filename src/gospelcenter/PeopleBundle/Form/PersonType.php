<?php

namespace gospelcenter\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\CelebrationBundle\Form\SpeakerOnlyType;
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\LocationBundle\Form\LocationSimpleType;

class PersonType extends AbstractType
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
            ->add('title',          'text')
            ->add('dateOfBirth',    'birthday', array('required' => false,
                                                      'widget'    => 'single_text'))
            ->add('email',          'text', array('required' => false))
            ->add('privatePhone',   'text', array('required' => false))
            ->add('mobilePhone',    'text', array('required' => false))
            ->add('notes',          'textarea', array('required' => false))
            ->add('languages',       'entity', array('class'         => 'gospelcenterLanguageBundle:Language',
                                                    'required'      => false,
                                                    'empty_value'   => 'Select languages',
                                                    'multiple'      => true,
                                                    'query_builder' => function(\gospelcenter\LanguageBundle\Entity\LanguageRepository $r) {
                                                        return $r->getSelectList();},
                                                    'property' => 'value'))
            ->add('abroad',         'checkbox', array('required' => false))
            ->add('hasChildren',    'checkbox', array('required' => false))
            ->add('function',       'text', array('required' => false))
            ->add('isSpeaker',      'checkbox', array('required' => false))
            ->add('isVisitor',      'checkbox', array('required' => false))
            ->add('isMember',       'checkbox', array('required' => false))
            ->add('image',          new ImageSimpleType(), array('required' => false))
            ->add('location',       new LocationSimpleType(), array('required' => false))
            
        ;
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
        return 'gospelcenter_peoplebundle_person';
    }
}
