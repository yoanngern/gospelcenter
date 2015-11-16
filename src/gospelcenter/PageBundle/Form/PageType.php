<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
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
                'ref',
                'choice',
                array(
                    'choices' => array(
                        'bases' => 'Bases',
                        'home' => 'Home'
                    ),
                    'multiple' => false,
                    'empty_value' => 'Select a menu'
                )
            )
            ->add(
                'title',
                'text',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Title')
                )
            )
            ->add(
                'slogan',
                'textarea',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Slogan')
                )
            )
            ->add(
                'language',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Language',
                    ),
                    'class' => 'gospelcenterLanguageBundle:Language',
                    'required' => true,
                    'label' => false,
                    'empty_value' => 'Select a language',
                    'query_builder' => function (\gospelcenter\LanguageBundle\Entity\LanguageRepository $r) {
                        return $r->getSelectList();
                    },
                    'translation_domain' => 'lang'
                )
            )
            ->add('slides', new SlideSimpleType($center), array('required' => false))
            ->add(
                'slides',
                "collection",
                array(
                    "type" => new SlideSimpleType($center),
                    'required' => false
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
                'data_class' => 'gospelcenter\PageBundle\Entity\Page'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_pagebundle_page';
    }
}
