<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TemplateEmail
 *
 * @ORM\Table(name="templateemail")
 * @ORM\Entity
 */
class TemplateEmail
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
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    private $activate;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="typeemail", type="string", length=255)
     */
    private $typeemail;

    /**
     * @var string
     *
     * @ORM\Column(name="recipient", type="string", length=255)
     */
    private $recipient;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="header", type="string", length=255)
     */
    private $header;


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
     * Set activate
     *
     * @param boolean $activate
     * @return TemplateEmail
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean 
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return TemplateEmail
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set recipient
     *
     * @param string $recipient
     * @return TemplateEmail
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return string 
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set typeemail
     *
     * @param string $typeemail
     * @return TemplateEmail
     */
    public function setTypeemail($typeemail)
    {
        $this->typeemail = $typeemail;

        return $this;
    }

    /**
     * Get typeemail
     *
     * @return string 
     */
    public function getTypeemail()
    {
        return $this->typeemail;
    }

    /**
     * Set header
     *
     * @param string $header
     * @return TemplateEmail
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string 
     */
    public function getHeader()
    {
        return $this->header;
    }
}
