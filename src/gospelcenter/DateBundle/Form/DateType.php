<?php

namespace gospelcenter\DateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'datetime', array('empty_value' => array(
                'year' => 'gc.generic.year', 'month' => 'gc.generic.month', 'day' => 'gc.generic.day'),
                'widget' => 'choice',
                'date_format' => 'd MMMM yyyy',
                'label' => 'gc.admin.date.start_date',
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
                    '55' => '55')))
            ->add('end', 'datetime', array('empty_value' => array(
                'year' => 'gc.generic.year', 'month' => 'gc.generic.month', 'day' => 'gc.generic.day'),
                'widget' => 'choice',
                'date_format' => 'd MMMM yyyy',
                'label' => 'gc.admin.date.end_date',
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
                    '55' => '55')));
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
        return 'gospelcenter_datebundle_date';
    }
}
