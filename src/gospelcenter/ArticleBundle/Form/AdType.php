<?php

namespace gospelcenter\ArticleBundle\Form;

use gospelcenter\ImageBundle\Form\ImageSimpleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                'showText',
                'checkbox',
                array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Show text')
                )
            )

            ->add('title', 'text', array(
                'attr' => array(
                    'placeholder' => 'Title'
                ),
                'label' => false,
                'required' => true,
            ))

            ->add('subtitle', 'text', array(
                'attr' => array(
                    'placeholder' => 'Subtitle'
                ),
                'label' => false,
                'required' => false,
            ))

            ->add('url', 'url', array(
                'attr' => array('placeholder' => 'Url'),
                'label' => false,
            ))

            ->add('type', 'choice', array(
                'choices' => array(
                    'home' => 'Homepage'
                ),
                'multiple' => false,
                'label' => false,
                'empty_value' => 'Select an emplacement'
            ))

            ->add('image', new ImageSimpleType(), array('required' => true));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\ArticleBundle\Entity\Ad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_articlebundle_ad';
    }
}
