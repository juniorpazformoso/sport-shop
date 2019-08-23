<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
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
     * @ORM\Column(name="prefixPhone", type="string", length=255)
     */
    private $prefixPhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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
     * @return Country
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
     * @return Country
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
     * Set prefixPhone
     *
     * @param string $prefixPhone
     * @return Country
     */
    public function setPrefixPhone($prefixPhone)
    {
        $this->prefixPhone = $prefixPhone;

        return $this;
    }

    /**
     * Get prefixPhone
     *
     * @return string 
     */
    public function getPrefixPhone()
    {
        return $this->prefixPhone;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Country
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    public function __toString() {
        return $this->name;
    }
}
