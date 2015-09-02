<?php

namespace MP\TimeSheetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MainContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom:'))
            ->add('surname', 'text', array('label' => 'Prénom:'))
            ->add('email', 'email', array('label' => 'Email:'))
            ->add('telNum', 'integer', array('label' => 'Numéro de téléphone:'))
            ->add('contactPost', 'text', array('label' => 'Poste:'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\TimeSheetBundle\Entity\MainContact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mp_timesheetbundle_maincontact';
    }
}
