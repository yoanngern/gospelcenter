<?php

namespace gospelcenter\EventBundle\Form;


use Doctrine\ORM\EntityRepository;
use gospelcenter\DateBundle\Form\DateType;
use gospelcenter\MediaBundle\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// FormType
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\ArticleBundle\Form\LinkType;

class EventType extends AbstractType
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
                'status',
                'checkbox',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Status')
                )
            )
            ->add(
                'title',
                'text',
                array(
                    'attr' => array('placeholder' => 'Title')
                )
            )
            ->add(
                'introText',
                'textarea',
                array(
                    'attr' => array('placeholder' => 'Intro text')
                )
            )
            ->add(
                'text',
                'textarea',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Full text')
                )
            )
            ->add(
                'location',
                'entity',
                array(
                    'class' => 'gospelcenterLocationBundle:Location',
                    'required' => false,
                    'empty_value' => 'Choose a location',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $r) use (
                        $center
                    ) {
                        return $r->getSelectList($center);
                    }
                )
            )
            /*
            ->add(
                'location',
                'entity',
                array(
                    'class' => 'gospelcenterLocationBundle:Location',
                    'property' => 'name',
                    'multiple' => false
                )
            )
            */

            ->add('picture', new ImageSimpleType(), array('required' => false))
            ->add('cover', new ImageSimpleType(), array('required' => false))
            ->add(
                'dates',
                'collection',
                array(
                    'attr' => array(
                        'class' => 'collection',
                        'data-add' => 'Add another date',
                        'data-add_first' => 'Add a date',
                        'data-remove' => 'Remove this date',
                        'data-label' => 'Date'
                    ),
                    'required' => false,
                    'type' => new DateType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
            ->add(
                'links',
                'collection',
                array(
                    'attr' => array(
                        'class' => 'collection links',
                        'data-add' => 'Add another link',
                        'data-add_first' => 'Add a link',
                        'data-remove' => 'Remove this link',
                        'data-label' => 'Link'
                    ),
                    'required' => false,
                    'type' => new LinkType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
            ->add('video', new VideoType(), array('required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\EventBundle\Entity\Event'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_eventbundle_event';
    }
}
