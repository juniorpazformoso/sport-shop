<?php

namespace A2lix\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\FormView,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    A2lix\TranslationFormBundle\TranslationForm\TranslationForm,
    A2lix\TranslationFormBundle\Form\EventListener\TranslationsFormsListener;

/**
 *
 * @author David ALLIX
 */
class TranslationsFormsType extends AbstractType
{
    private $translationForm;
    private $translationsListener;
    private $locales;
    private $defaultLocale;
    private $defaultRequired;

    /**
     *
     * @param \A2lix\TranslationFormBundle\TranslationForm\TranslationForm $translationForm
     * @param \A2lix\TranslationFormBundle\Form\EventListener\TranslationsFormsListener $translationsListener
     * @param array $locales
     * @param string $defaultLocale
     * @param boolean $defaultRequired
     */
    public function __construct(TranslationForm $translationForm, TranslationsFormsListener $translationsListener, array $locales, $defaultLocale, $defaultRequired)
    {
        $this->translationForm = $translationForm;
        $this->translationsListener = $translationsListener;
        $this->locales = $locales;
        $this->defaultLocale = $defaultLocale;
        $this->defaultRequired = $defaultRequired;
    }

    /**
     * 
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->translationsListener);

        $formsOptions = $this->translationForm->getFormsOptions($options);
        foreach ($options['locales'] as $locale) {
            if (isset($formsOptions[$locale])) {
                $builder->add($locale, $options['form_type'], $formsOptions[$locale]);
            }
        }
    }
    
    /**
     * 
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['default_locale'] = $this->defaultLocale;
    }   

    /**
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'by_reference' => false,
            'required' => $this->defaultRequired,
            'locales' => $this->locales,
            'form_type' => null,
            'form_options' => array(),
        ));
    }

    public function getName()
    {
        return 'a2lix_translationsForms';
    }
}
