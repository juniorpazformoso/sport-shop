<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CountrySenderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('pricefree')
            ->add('active')
            ->add('country', 'entity', array('class' => 'ServiceBundle:Country', 'placeholder' => '-- Seleccionar --'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\CountrySend'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_freeshippingcountry';
    }
}
