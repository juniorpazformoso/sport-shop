<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteOptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailServerIp')
            ->add('emailServerPort')
            ->add('emailServerAddress')
            ->add('emailServerPassword')
            ->add('authServerSmtp')
            ->add('socialFacebookUrl')
            ->add('instagramUrl')
            ->add('socialTwitterUrl')
            ->add('youtubeUrl')
            ->add('linkedinUrl')
            ->add('paypalSandbox')
            ->add('currencyCode')
            ->add('paypalId')
            ->add('paypalActive')
            ->add('tpvActive')
            ->add('effectiveActive')
            ->add('rePaymentActive')
            //->add('phoneOne')
            //->add('phoneTwo')
            //->add('email')
            //->add('address')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\SiteOption'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_siteoption';
    }
}
