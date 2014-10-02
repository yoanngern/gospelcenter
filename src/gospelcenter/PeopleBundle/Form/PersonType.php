<?php

namespace gospelcenter\PeopleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use gospelcenter\CelebrationBundle\Form\SpeakerOnlyType;
use gospelcenter\ImageBundle\Form\ImageSimpleType;
use gospelcenter\LocationBundle\Form\LocationSimpleType;

use gospelcenter\PeopleBundle\Form\Type\TelType;
use gospelcenter\PeopleBundle\Form\Type\ErrorType;

use gospelcenter\UserBundle\Form\Type\RegistrationWithUnitFormType;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Firstname',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'lastname',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Lastname',
                    ),
                    'required' => true,
                    'label' => false,
                )
            )
            ->add(
                'user',
                new RegistrationWithUnitFormType('gospelcenter\UserBundle\Entity\User'),
                array('required' => false)
            )
            ->add(
                'gender',
                'choice',
                array(
                    'attr' => array(
                        'placeholder' => 'Title',
                        'class' => 'radio'
                    ),
                    'choices' => array(
                        'man' => 'Man',
                        'woman' => 'Woman',
                    ),
                    'required' => true,
                    'label' => false,
                    'multiple' => false,
                    'expanded' => true
                )
            )
            ->add(
                'dateOfBirth',
                'birthday',
                array(
                    'empty_value' => array(
                        'year' => 'Year',
                        'month' => 'Month',
                        'day' => 'Day'
                    ),
                    'format' => 'd MMMM yyyy'
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'attr' => array(
                        'placeholder' => 'Email',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'privatePhone',
                new TelType(),
                array(
                    'attr' => array(
                        'placeholder' => 'Private phone',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'mobilePhone',
                new TelType(),
                array(
                    'attr' => array(
                        'placeholder' => 'Mobile phone',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'notes',
                'textarea',
                array(
                    'attr' => array(
                        'placeholder' => 'Notes',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'languages',
                'entity',
                array(
                    'attr' => array(
                        'placeholder' => 'Language',
                        'class' => 'selectMultiple'
                    ),
                    'class' => 'gospelcenterLanguageBundle:Language',
                    'required' => false,
                    'label' => false,
                    'empty_value' => 'Select languages',
                    'multiple' => true,
                    'query_builder' => function (\gospelcenter\LanguageBundle\Entity\LanguageRepository $r) {
                        return $r->getSelectList();
                    },
                    'translation_domain' => 'lang'
                )
            )
            ->add(
                'abroad',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'is he abroad',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'hasChildren',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'has children',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'function',
                'text',
                array(
                    'attr' => array(
                        'placeholder' => 'Function',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'isSpeaker',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'is speaker',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'isVisitor',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'is visitor',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'isGlobal',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'is global',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'isMember',
                'checkbox',
                array(
                    'attr' => array(
                        'placeholder' => 'is member',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add(
                'image',
                new ImageSimpleType(),
                array(
                    'attr' => array(
                        'placeholder' => 'Image',
                    ),
                    'required' => false,
                    'label' => false,
                )
            )
            ->add('location', new LocationSimpleType(), array('required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'gospelcenter\PeopleBundle\Entity\Person'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gospelcenter_peoplebundle_person';
    }
}
