<?php

namespace GruponivCPH\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AnswerTicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticket', 'hidden', array('mapped' => false))
            ->add('user', 'hidden', array('mapped' => false))
            ->add('answer', 'textarea', array('attr' => array('rows' => 8)));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GruponivCPH\ServiceBundle\Entity\AnswerTicket'
        ));
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'gruponivcph_servicebundle_answer';
    }
}
