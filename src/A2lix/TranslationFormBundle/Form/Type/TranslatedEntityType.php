<?php

namespace A2lix\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\OptionsResolver\Options,
    Symfony\Component\HttpFoundation\Request;

/**
 * Translated entity
 *
 * @author David ALLIX
 */
class TranslatedEntityType extends AbstractType
{
    private $request;
    
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $request = $this->request;
        $resolver->setDefaults(array(
            'translation_path' => 'translations',
            'translation_property' => null,
            'property' => function(Options $options) use ($request) {
                if (null === $request) {
                    throw new \Exception('Error while getting request');
                }
                
                return $options['translation_path'] .'['. $request->getLocale() .'].'. $options['translation_property'];
            },
        ));
    }

    public function getParent()
    {
        return 'entity';
    }
    
    public function getName()
    {
        return 'a2lix_translatedEntity';
    }
}
