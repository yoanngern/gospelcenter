<?php

namespace gospelcenter\CelebrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\MediaBundle\Form\VideoType;
use gospelcenter\MediaBundle\Form\AudioType;
use gospelcenter\PeopleBundle\Form\RoleType;

class CelebrationType extends AbstractType
{

    public function __construct($options = null)
    {
        $this->center = $options;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $center = $this->center;

        $builder
            ->add(
                'title',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Title',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'dateLocal',
                'date',
                array(
                    'empty_value' => array(
                        'year' => 'Year',
                        'month' => 'Month',
                        'day' => 'Day'
                    ),
                    'format' => 'd MMMM yyyy',
                    'label' => false,
                )
            )
            ->add(
                'startingTime',
                'time',
                array(
                    'attr' => array(
                        'placeholder' => 'Starting time',
                    ),
                    'input' => 'datetime',
                    'minutes' => array(
                        '00' => '00',
                        '05' => '05',
                        '10' => '10',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                        '55' => '55'
                    ),
                    'label' => false,
                )
            )
            ->add(
                'endingTime',
                'time',
                array(
                    'attr' => array(
                        'placeholder' => 'Ending time',
                    ),
                    'input' => 'datetime',
                    'minutes' => array(
                        '00' => '00',
                        '05' => '05',
                        '10' => '10',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                        '55' => '55'
                    ),
                    'label' => false,
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'attr' => array(
                        'placeholder' => 'Description',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'status',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'Status',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'bestOf',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'Best of',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'kidsProgram',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'Kids program',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add('image', new ImageSimpleType(), array('required' => false))
            ->add(
                'location',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Location',
                    ),
                    'class' => 'gospelcenterLocationBundle:Location',
                    'required' => false,
                    'empty_value' => 'Choose a location',
                    'query_builder' => function (\gospelcenter\LocationBundle\Entity\LocationRepository $r) use (
                        $center
                    ) {
                        return $r->getSelectList($center);
                    },
                    'label' => false,
                )
            )
            ->add('video', new VideoType(), array('required' => false))
            ->add(
                'audio',
                new AudioType(),
                array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'selectList'
                    )
                )
            )
            /*
            ->add(
                'tags',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Tags',
                        'class' => 'selectMultiple'
                    ),
                    'class' => 'gospelcenterCelebrationBundle:Tag',
                    'property' => 'value',
                    'multiple' => true,
                    'required' => false,
                    'label' => false,
                )
            )*/


            ->add(
                'existingSpeakers',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Speakers',
                        'class' => 'speakers'
                    ),
                    'class' => 'gospelcenterCelebrationBundle:Speaker',
                    'required' => false,
                    'empty_value' => 'Choose a speaker',
                    'multiple' => true,
                    'query_builder' => function (\gospelcenter\CelebrationBundle\Entity\SpeakerRepository $r) {
                        return $r->getSelectList();
                    },
                    'property' => 'select',
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
                'data_class' => 'gospelcenter\CelebrationBundle\Entity\Celebration'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_celebrationbundle_celebration';
    }
}
