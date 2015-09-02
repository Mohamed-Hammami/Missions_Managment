<?php

namespace MP\TimeSheetBundle\Form;

use MP\TimeSheetBundle\Entity\Associate;
use MP\TimeSheetBundle\Entity\AssociateRepository;
use MP\TimeSheetBundle\Entity\MissionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimeSheetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', 'date', array(
                    'label' => 'Jour:',
                    'data' => new \DateTime(),
                    'read_only' => true,
                ))
            ->add('hourNumber', 'number', array(
                    'label' => "Nomre d'heures travaillées:",
                    'data' => 8.5,
                ))
            ->add('holiday', 'checkbox', array(
                    'label' => "Journée de congé:",
                    'required' => false,
                ))
            ->add('comment', 'text', array(
                    'label' => 'commentaire:',
                    'required' => false,
                ))
            ->add('associate', 'entity', array(
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo) use($options)
                    {
                        if ( isset($options['associateId'])){
                            return $repo->findAssociate($options['associateId']);
                        }
                    },
                    'label' => 'Collaborateur:',
                ))
            ->add('mission', 'entity', array(
                    'class' => 'MPTimeSheetBundle:Mission',
                    'query_builder' => function(MissionRepository $repo) use($options )
                    {
                        if ( isset($options['associateId']) ){
                            return $repo->findMissions($options['associateId']);
                        }
                    },
                    'label' => 'Mission:',
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\TimeSheetBundle\Entity\TimeSheet',
            'associateId' => '',
            'admin' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mp_timesheetbundle_timesheet';
    }
}
