<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarrierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('transitTime')
            ->add('speedRating')
            ->add('urlTracking')
            ->add('freeShipping')
            ->add('billing', 'choice', array('choices' => array('precio_total' => 'De acuerdo con el precio total', 'peso_total' => 'De acuerdo con el peso total')))
            ->add('maximumPackageHeight')
            ->add('maximumPackageWidth')
            ->add('maximumDepthPackage')
            ->add('maximumPackageWeight')
            ->add('taxZone', 'entity', array('class' => 'ServiceBundle:TaxZone', 'placeholder' => 'Sin impuestos'))
            ->add('taxCountry', 'entity', array('class' => 'ServiceBundle:TaxCountry', 'placeholder' => 'Sin impuestos'))
            ->add('logoFile', 'file')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\Carrier'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_carrier';
    }
}
