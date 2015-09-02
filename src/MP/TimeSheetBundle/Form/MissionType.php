<?php

namespace MP\TimeSheetBundle\Form;

use MP\TimeSheetBundle\Entity\AssociateRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', 'date', array(
                    'label' => 'Date de début:',
                ))
            ->add('hourNum', 'number', array(
                    'label' => 'Cout prévisionnel(en heures):',
                ))
            ->add('endDate', 'date', array(
                    'label' => 'Date de fin prévisionnel:',
                ))
            ->add('nature', 'entity', array(
                    'label' => 'Nature:',
                    'class' => 'MPTimeSheetBundle:Nature',
                ))
            ->add('clients')
            ->add('associates', 'entity', array(
                   'label' => 'Associés:',
                   'class' => 'MPTimeSheetBundle:Associate',
                   'query_builder' => function(AssociateRepository $repo){
                        return $repo->findNoMissionAssociates();
                   },
                   'multiple' => true,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\TimeSheetBundle\Entity\Mission'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mp_timesheetbundle_mission';
    }
}
