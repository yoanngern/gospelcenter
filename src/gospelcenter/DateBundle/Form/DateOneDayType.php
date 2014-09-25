<?php

namespace gospelcenter\DateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateOneDayType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('oneDate', 'datetime', array('widget' => 'single_text'))
            //->add('startingTime', 'time', array('widget' => 'single_text'))
            //->add('endingTime', 'time', array('widget' => 'single_text'));
            ->add('oneDate', 'date')
            ->add('startingTime', 'time')
            ->add('endingTime', 'time');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\DateBundle\Entity\Date'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_datebundle_date_oneDay';
    }
}
