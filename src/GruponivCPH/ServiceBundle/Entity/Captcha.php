<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 */
class Captcha
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $captcha;

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
     * Set captcha
     *
     * @param string $captcha
     * @return Captcha
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
    
        return $this;
    }

    /**
     * Get captcha
     *
     * @return string 
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    public function __toString()
    {
        return $this->getCaptcha();
    }
}
