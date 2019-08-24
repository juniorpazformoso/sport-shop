<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity
 */
class Language
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="codeIso", type="string", length=255)
     */
    private $codeIso;

    /**
     * @var string
     *
     * @ORM\Column(name="codeLanguage", type="string", length=255)
     */
    private $codeLanguage;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set codeIso
     *
     * @param string $codeIso
     * @return Language
     */
    public function setCodeIso($codeIso)
    {
        $this->codeIso = $codeIso;

        return $this;
    }

    /**
     * Get codeIso
     *
     * @return string 
     */
    public function getCodeIso()
    {
        return $this->codeIso;
    }

    /**
     * Set codeLanguage
     *
     * @param string $codeLanguage
     * @return Language
     */
    public function setCodeLanguage($codeLanguage)
    {
        $this->codeLanguage = $codeLanguage;

        return $this;
    }

    /**
     * Get codeLanguage
     *
     * @return string 
     */
    public function getCodeLanguage()
    {
        return $this->codeLanguage;
    }
}
