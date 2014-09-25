<?php

namespace gospelcenter\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', 'url', array(
                'attr' => array('placeholder' => 'Url'),
                'label' => false,
            ))

            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Name',
                    'class' => 'name'
                ),
                'label' => false,
            ))

            ->add('type', 'choice', array(
                'choices' => array(
                    'link' => 'Website',
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter',
                    'youtube' => 'YouTube',
                    'googleplus' => 'Google+'
                ),
                'multiple' => false,
                'label' => false,
                'empty_value' => 'Select a type'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\ArticleBundle\Entity\Link'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_articlebundle_link';
    }
}
