<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea', array('required' => false))
            ->add('pictureFile', 'file')
            ->add('pictureHoverFile', 'file')
            ->add('relateProduct')    
            ->add('categories')
            ->add('shortDescription')
            ->add('price')
            ->add('basePrice')
            ->add('ref')
            ->add('count')
            ->add('ranking', "choice", array('choices' => array('1' => '1', '2' => '2',
                '3' => '3', '4' => '4', '5' => '5'), 'placeholder' => '-- Seleccionar --'))
            ->add('sectionProduct', "choice", array('choices' => array('Palas superior' => 'Palas superior', 'Palas inferior' => 'Palas inferior'), 'placeholder' => '-- Seleccionar --'))
            ->add('tags')
            ->add('visibleInHome')
            ->add('video')                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_product';
    }
}
