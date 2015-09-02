<?php

namespace MP\TimeSheetBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AssociateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label' => 'Nom:',
                    'disabled' => $options['edit']? true: false,
                ))
            ->add('surname', 'text', array(
                    'label' => 'Prenom:',
                    'disabled' => $options['edit']? true: false,
                ))
            ->add('email', 'email', array('label' => 'Email:'))
            ->add('department', 'entity', array(
                    'class' => 'MPTimeSheetBundle:Department',
                    'label' => 'Département:',
                    'disabled' => $options['firstLogin']? true: false,
                ))
            ->add('post', 'choice', array(
                    'label' => 'Poste:',
                    'choices' => array(
                        'collaborateur' => 'collaborateur',
                        'manager' => 'manager',
                        'signataire' => 'signataire',
                        'chef de mission' => 'chef de mission',
                    ),
                    'disabled' => $options['firstLogin']? true: false,
                ));

        if ( $options['firstLogin'] ){
            $builder->add('username', 'text', array(
                        'label' => 'Login:',
                    ));
            $builder->add('password', 'repeated', array(
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Mot de passe (validation)'),
                    'type' => 'password'
                ));
        }

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\TimeSheetBundle\Entity\Associate',
            'edit' => false,
            'firstLogin' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mp_timesheetbundle_associate';
    }
}
