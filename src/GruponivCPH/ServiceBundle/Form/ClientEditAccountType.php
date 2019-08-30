<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientEditAccountType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('mapped' => false))
            ->add('lastName', 'text', array('mapped' => false))            
            ->add('dni_nif', 'text', array('mapped' => false))
            ->add('age', 'text', array('mapped' => false))
            ->add('gender', 'entity', array('class' => 'ServiceBundle:Gender', 
                'multiple' => false, 
                'expanded' => true, 'mapped' => false))
        ;
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_client_user';
    }
}
