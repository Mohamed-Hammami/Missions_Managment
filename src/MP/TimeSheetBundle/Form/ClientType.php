<?php

namespace MP\TimeSheetBundle\Form;

use MP\TimeSheetBundle\Entity\MainContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom:'))
            ->add('adresse', 'text', array('label' => 'Adresse:'))
            ->add('secteurActivite', 'text', array('label' => "Secteur d'activité"))
            ->add('mainContact', new MainContactType(), array('label' => 'Contact Principal:'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\TimeSheetBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mp_timesheetbundle_client';
    }
}
