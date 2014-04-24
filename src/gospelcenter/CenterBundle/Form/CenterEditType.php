<?php

namespace gospelcenter\CenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// FormType
use gospelcenter\CenterBundle\Form\CenterType;

class CenterEditType extends CenterType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->remove('ref');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gospelcenter\CenterBundle\Entity\Center'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_centerbundle_centeredittype';
    }
}
