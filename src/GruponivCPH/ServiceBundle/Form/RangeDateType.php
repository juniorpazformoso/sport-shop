<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RangeDateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', 'datetime', array('attr'=>array('class'=>'form-control'), 'mapped' => false,  'label' => 'Fecha incio', 
                'widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
            ->add('endDate', 'datetime', array('attr'=>array('class'=>'form-control'), 'mapped' => false,  'label' => 'Fecha incio', 
                'widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
        ;
    }
    
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_rangedate';
    }
}
