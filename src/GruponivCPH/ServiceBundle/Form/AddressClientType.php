<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('town')
            ->add('enterprise')
            ->add('postalCode')
            ->add('city')
            ->add('location')
            ->add('province', 'entity', array('class' => 'ServiceBundle:Province', 'placeholder' => '-- Seleccionar --'))
            ->add('community', 'entity', array('class' => 'ServiceBundle:Community', 'placeholder' => '-- Seleccionar --'))
            ->add('client', 'entity', array('class' => 'ServiceBundle:Client', 'placeholder' => '-- Seleccionar --'))
            ->add('country', 'entity', array('class' => 'ServiceBundle:Country', 'placeholder' => '-- Seleccionar --'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\AddressClient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_addressclient';
    }
}
