<?php

namespace GruponivCPH\ServiceBundle\Form;

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
            
            ->add('name')
            ->add('lastName')            
            ->add('dni_nif')
            ->add('email')
            ->add('active')
            ->add('age', 'text')
            ->add('gender', 'entity', array('class' => 'ServiceBundle:Gender', 'placeholder' => '-- Seleccionar --'))
            ->add('gender', 'entity', array('class' => 'ServiceBundle:Gender', 'placeholder' => '-- Seleccionar --'))
            ->add('role', 'choice', array('mapped' => false,
                    'choices' => array('ROLE_CLIENTE' => 'Cliente online', 
                                            'ROLE_TIENDA' => 'Tienda')));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_client';
    }
}
