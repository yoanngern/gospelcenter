<?php

namespace gospelcenter\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function __construct($options = null) {
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
            ->add('ref',            'choice', array(
                                        'choices'   => array(
                                            'bases'     => 'Bases',
                                            'minis'     => 'Youth - Gospel Minis',
                                            'kids' => 'Youth - Gospel Kids',
                                            'teens'  => 'Youth - Gospel Teens',
                                            'fullPack'  => 'Youth - Full Pack',
                                            'youth'     => 'Youth - Gospel Youth'
                                        ),
                                        'multiple'  => false,
                                        'empty_value'   => 'Select a menu'))
            ->add('title',          'text')
            ->add('slogan',         'textarea', array('required' => false))
            ->add('template',       'choice', array(
                                        'choices'   => array(
                                            'simple'    => 'Simple',
                                            'full'      => 'Full',
                                            'complex'   => 'Complex',
                                            'youth'     => 'Youth'
                                        ),  
                                        'multiple'  => false,
                                        'empty_value'   => 'Select a template',))
            ->add('language',      'entity', array('class'         => 'gospelcenterLanguageBundle:Language',
                                                    'required'      => true,
                                                    'empty_value'   => 'Select a language',
                                                    'query_builder' => function(\gospelcenter\LanguageBundle\Entity\LanguageRepository $r) {
                                                        return $r->getSelectList();}))
            ->add('slides',          new SlideSimpleType($center), array('required' => false))
            ->add('slides',          "collection", array("type"=> new SlideSimpleType($center),
                                                            'required'      => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\PageBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_pagebundle_page';
    }
}
