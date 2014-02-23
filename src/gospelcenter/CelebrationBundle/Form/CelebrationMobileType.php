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


class CelebrationMobileType extends CelebrationType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->remove('date')
            ->add('date',       'date', array('widget' => 'single_text'))
        
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
        return 'gospelcenter_celebrationbundle_celebrationmobiletype';
    }
}
