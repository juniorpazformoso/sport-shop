<?php

namespace GruponivCPH\ServiceBundle\Form;

use GruponivCPH\ServiceBundle\Entity\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            
            /*
            ->add('belong', 'entity', array(
                'class' => 'GruponivCPH\ServiceBundle\Entity\Category',
                'empty_data'  => null,
                'empty_value' => 'Ninguna',
                'multiple' => false,
                'required' => false,
                'query_builder' => function ($cr) {
                    return $cr->createQueryBuilder('c')
                        ->where('c.belong is null');
                }
            ))
             * 
             */
            
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_category';
    }
}
