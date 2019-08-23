<?php

namespace A2lix\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 *
 * @author David ALLIX
 */
class TranslationsLocalesSelectorType extends AbstractType
{
    private $locales;
    private $defaultLocale;

    /**
     *
     * @param array $locales
     * @param string $defaultLocale
     */
    public function __construct(array $locales, $defaultLocale)
    {
        $this->locales = $locales;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array_combine($this->locales, $this->locales),
            'expanded' => true,
            'multiple' => true,
            'attr' => array(
                'class' => "a2lix_translationsLocalesSelector"
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'a2lix_translationsLocalesSelector';
    }

}
