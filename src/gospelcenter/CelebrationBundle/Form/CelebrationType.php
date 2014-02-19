<?php

namespace gospelcenter\CelebrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// FormType
use gospelcenter\CenterBundle\Form\CenterType;
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\LocationBundle\Form\LocationType;
use gospelcenter\MediaBundle\Form\VideoType;
use gospelcenter\MediaBundle\Form\AudioType;
use gospelcenter\CelebrationBundle\Form\TagType;
use gospelcenter\CelebrationBundle\Form\SpeakerType;
use gospelcenter\PeopleBundle\Form\RoleType;


class CelebrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',              'text', array('required' => false))
            ->add('date',               'date', array('widget' => 'single_text'))
            ->add('startingTime',       'time', array('widget' => 'single_text'))
            ->add('endingTime',         'time', array('widget' => 'single_text'))
            ->add('description',        'textarea', array('required' => false))
            ->add('status',             'checkbox', array('required' => false))
            ->add('bestOf',             'checkbox', array('required' => false))
            ->add('kidsProgram',        'checkbox', array('required' => false))
            ->add('image',              new ImageSimpleType(), array('required' => false))
            ->add('location',           new LocationType())
            ->add('location',           'entity', array('class'         => 'gospelcenterLocationBundle:Location',
                                                        'required'      => false,
                                                        'empty_value'   => 'Choose a location',
                                                        'query_builder' => function(\gospelcenter\LocationBundle\Entity\LocationRepository $r) {
                                                            return $r->getSelectList();
                                                        }))
            ->add('video',              new VideoType(), array('required' => false))
            ->add('audio',              new AudioType(), array('required' => false))
            ->add('tags',               'entity', array('class'     => 'gospelcenterCelebrationBundle:Tag',
                                                        'property'  => 'value',
                                                        'multiple'  => true))
            ->add('existingSpeakers',   'entity', array('class'         => 'gospelcenterCelebrationBundle:Speaker',
                                                        'required'      => false,
                                                        'empty_value'   => 'Choose a speaker',
                                                        'multiple'      => true,
                                                        'query_builder' => function(\gospelcenter\CelebrationBundle\Entity\SpeakerRepository $r) {
                                                            return $r->getSelectList();},
                                                        'property' => 'select'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\CelebrationBundle\Entity\Celebration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_celebrationbundle_celebration';
    }
}
