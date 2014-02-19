<?php

namespace gospelcenter\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// FormType
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\LocationBundle\Form\LocationType;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          'text')
            ->add('startingDate',   'date', array('widget' => 'single_text'))
            ->add('endingDate',     'date', array('widget' => 'single_text'))
            ->add('status',         'checkbox', array('required' => false))
            ->add('introText',      'textarea')
            ->add('text',           'textarea')
            ->add('location',       'entity', array('class'         => 'gospelcenterLocationBundle:Location',
                                                        'required'      => false,
                                                        'empty_value'   => 'Choose a location',
                                                        'query_builder' => function(\gospelcenter\LocationBundle\Entity\LocationRepository $r) {
                                                            return $r->getSelectList();
                                                        }))
            ->add('picture',        new ImageSimpleType(), array('required' => false))
            ->add('cover',          new ImageSimpleType(), array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\EventBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_eventbundle_event';
    }
}
