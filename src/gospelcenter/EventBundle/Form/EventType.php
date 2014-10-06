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

    protected $container;

    public function __construct($options = null, $container)
    {
        $this->center = $options;
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $center = $this->center;

        $translator = $this->container->get('translator');

        $builder
            ->add(
                'status',
                'checkbox',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'gc.admin.events.status')
                )
            )
            ->add(
                'title',
                'text',
                array(
                    'attr' => array('placeholder' => 'gc.admin.events.title')
                )
            )
            ->add(
                'introText',
                'textarea',
                array(
                    'attr' => array('placeholder' => 'gc.admin.events.intro_text')
                )
            )
            ->add(
                'text',
                'textarea',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'gc.admin.events.full_text')
                )
            )
            ->add(
                'location',
                'entity',
                array(
                    'class' => 'gospelcenterLocationBundle:Location',
                    'required' => false,
                    'empty_value' => 'gc.admin.events.choose_location',
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
                        'data-add' => $translator->trans('gc.admin.events.date.add_another'),
                        'data-add_first' => $translator->trans('gc.admin.events.date.add'),
                        'data-remove' => $translator->trans('gc.admin.events.date.remove'),
                        'data-label' => $translator->trans('gc.admin.events.date.title')
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
                        'data-add' => $translator->trans('gc.admin.events.links.add_another'),
                        'data-add_first' => $translator->trans('gc.admin.events.links.add'),
                        'data-remove' => $translator->trans('gc.admin.events.links.remove'),
                        'data-label' => $translator->trans('gc.admin.events.link')
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
