<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteOption
 *
 * @ORM\Table(name="siteoption")
 * @ORM\Entity
 */
class SiteOption
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
     * @ORM\Column(name="emailServerIp", type="string", length=255)
     */
    private $emailServerIp;

    /**
     * @var string
     *
     * @ORM\Column(name="emailServerPort", type="string", length=255)
     */
    private $emailServerPort;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="authServerSmtp", type="boolean")
     */
    private $authServerSmtp;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="tpvActive", type="boolean")
     */
    private $tpvActive;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="rePayment", type="boolean")
     */
    private $rePaymentActive;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="paypalActive", type="boolean")
     */
    private $paypalActive;
    
    
    /**
     *
     * @ORM\Column(name="effectiveActive", type="boolean")
     */
    private $effectiveActive;

    /**
     * @var string
     *
     * @ORM\Column(name="emailServerProtocol", type="string", length=255)
     */
    private $emailServerProtocol;

    
    /**
     *
     * @ORM\Column(name="paypalId", type="string", length=255)
     */
    private $paypalId;
    
    
    /**
     *
     * @ORM\Column(name="currencyCode", type="string", length=255)
     */
    private $currencyCode;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="paypalSandbox", type="boolean")
     */
    private $paypalSandbox;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="emailServerAddress", type="string", length=255)
     */
    private $emailServerAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="emailServerPassword", type="string", length=255)
     */
    private $emailServerPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="socialFacebookUrl", type="string", length=255)
     */
    private $socialFacebookUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="socialTwitterUrl", type="string", length=255)
     */
    private $socialTwitterUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="instagramUrl", type="string", length=255)
     */
    private $instagramUrl;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="linkedinUrl", type="string", length=255)
     */
    private $linkedinUrl;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="youtubeUrl", type="string", length=255)
     */
    private $youtubeUrl;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="phoneOne", type="string", length=255)
     */
    private $phoneOne;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="phoneTwo", type="string", length=255)
     */
    private $phoneTwo;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;


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
     * Set emailServerIp
     *
     * @param string $emailServerIp
     * @return SiteOption
     */
    public function setEmailServerIp($emailServerIp)
    {
        $this->emailServerIp = $emailServerIp;

        return $this;
    }

    /**
     * Get emailServerIp
     *
     * @return string 
     */
    public function getEmailServerIp()
    {
        return $this->emailServerIp;
    }

    /**
     * Set emailServerPort
     *
     * @param string $emailServerPort
     * @return SiteOption
     */
    public function setEmailServerPort($emailServerPort)
    {
        $this->emailServerPort = $emailServerPort;

        return $this;
    }

    /**
     * Get emailServerPort
     *
     * @return string 
     */
    public function getEmailServerPort()
    {
        return $this->emailServerPort;
    }

    /**
     * Set emailServerProtocol
     *
     * @param string $emailServerProtocol
     * @return SiteOption
     */
    public function setEmailServerProtocol($emailServerProtocol)
    {
        $this->emailServerProtocol = $emailServerProtocol;

        return $this;
    }

    /**
     * Get emailServerProtocol
     *
     * @return string 
     */
    public function getEmailServerProtocol()
    {
        return $this->emailServerProtocol;
    }

    /**
     * Set emailServerAddress
     *
     * @param string $emailServerAddress
     * @return SiteOption
     */
    public function setEmailServerAddress($emailServerAddress)
    {
        $this->emailServerAddress = $emailServerAddress;

        return $this;
    }

    /**
     * Get emailServerAddress
     *
     * @return string 
     */
    public function getEmailServerAddress()
    {
        return $this->emailServerAddress;
    }

    /**
     * Set emailServerPassword
     *
     * @param string $emailServerPassword
     * @return SiteOption
     */
    public function setEmailServerPassword($emailServerPassword)
    {
        $this->emailServerPassword = $emailServerPassword;

        return $this;
    }

    /**
     * Get emailServerPassword
     *
     * @return string 
     */
    public function getEmailServerPassword()
    {
        return $this->emailServerPassword;
    }

    /**
     * Set socialFacebookUrl
     *
     * @param string $socialFacebookUrl
     * @return SiteOption
     */
    public function setSocialFacebookUrl($socialFacebookUrl)
    {
        $this->socialFacebookUrl = $socialFacebookUrl;

        return $this;
    }

    /**
     * Get socialFacebookUrl
     *
     * @return string 
     */
    public function getSocialFacebookUrl()
    {
        return $this->socialFacebookUrl;
    }

    /**
     * Set socialgplusUrl
     *
     * @param string $socialgplusUrl
     * @return SiteOption
     */
    public function setSocialgplusUrl($socialgplusUrl)
    {
        $this->socialgplusUrl = $socialgplusUrl;

        return $this;
    }

    /**
     * Get socialgplusUrl
     *
     * @return string 
     */
    public function getSocialgplusUrl()
    {
        return $this->socialgplusUrl;
    }

    /**
     * Set youtubeUrl
     *
     * @param string $youtubeUrl
     * @return SiteOption
     */
    public function setYoutubeUrl($youtubeUrl)
    {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    /**
     * Get youtubeUrl
     *
     * @return string 
     */
    public function getYoutubeUrl()
    {
        return $this->youtubeUrl;
    }

    /**
     * Set socialTwitterUrl
     *
     * @param string $socialTwitterUrl
     * @return SiteOption
     */
    public function setSocialTwitterUrl($socialTwitterUrl)
    {
        $this->socialTwitterUrl = $socialTwitterUrl;

        return $this;
    }

    /**
     * Get socialTwitterUrl
     *
     * @return string 
     */
    public function getSocialTwitterUrl()
    {
        return $this->socialTwitterUrl;
    }

    /**
     * Set instagramUrl
     *
     * @param string $instagramUrl
     * @return SiteOption
     */
    public function setInstagramUrl($instagramUrl)
    {
        $this->instagramUrl = $instagramUrl;

        return $this;
    }

    /**
     * Get instagramUrl
     *
     * @return string 
     */
    public function getInstagramUrl()
    {
        return $this->instagramUrl;
    }

    /**
     * Set linkedinUrl
     *
     * @param string $linkedinUrl
     * @return SiteOption
     */
    public function setLinkedinUrl($linkedinUrl)
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    /**
     * Get linkedinUrl
     *
     * @return string 
     */
    public function getLinkedinUrl()
    {
        return $this->linkedinUrl;
    }

    /**
     * Set phoneOne
     *
     * @param string $phoneOne
     * @return SiteOption
     */
    public function setPhoneOne($phoneOne)
    {
        $this->phoneOne = $phoneOne;

        return $this;
    }

    /**
     * Get phoneOne
     *
     * @return string 
     */
    public function getPhoneOne()
    {
        return $this->phoneOne;
    }

    /**
     * Set phoneTwo
     *
     * @param string $phoneTwo
     * @return SiteOption
     */
    public function setPhoneTwo($phoneTwo)
    {
        $this->phoneTwo = $phoneTwo;

        return $this;
    }

    /**
     * Get phoneTwo
     *
     * @return string 
     */
    public function getPhoneTwo()
    {
        return $this->phoneTwo;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return SiteOption
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return SiteOption
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set paypalId
     *
     * @param string $paypalId
     * @return SiteOption
     */
    public function setPaypalId($paypalId)
    {
        $this->paypalId = $paypalId;

        return $this;
    }

    /**
     * Get paypalId
     *
     * @return string 
     */
    public function getPaypalId()
    {
        return $this->paypalId;
    }

    /**
     * Set currencyCode
     *
     * @param string $currencyCode
     * @return SiteOption
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    /**
     * Get currencyCode
     *
     * @return string 
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Set paypalSandbox
     *
     * @param boolean $paypalSandbox
     * @return SiteOption
     */
    public function setPaypalSandbox($paypalSandbox)
    {
        $this->paypalSandbox = $paypalSandbox;

        return $this;
    }

    /**
     * Get paypalSandbox
     *
     * @return boolean 
     */
    public function getPaypalSandbox()
    {
        return $this->paypalSandbox;
    }

    /**
     * Set tpvActive
     *
     * @param boolean $tpvActive
     * @return SiteOption
     */
    public function setTpvActive($tpvActive)
    {
        $this->tpvActive = $tpvActive;

        return $this;
    }

    /**
     * Get tpvActive
     *
     * @return boolean 
     */
    public function getTpvActive()
    {
        return $this->tpvActive;
    }

    /**
     * Set rePaymentActive
     *
     * @param boolean $rePaymentActive
     * @return SiteOption
     */
    public function setRePaymentActive($rePaymentActive)
    {
        $this->rePaymentActive = $rePaymentActive;

        return $this;
    }

    /**
     * Get rePaymentActive
     *
     * @return boolean 
     */
    public function getRePaymentActive()
    {
        return $this->rePaymentActive;
    }

    /**
     * Set paypalActive
     *
     * @param boolean $paypalActive
     * @return SiteOption
     */
    public function setPaypalActive($paypalActive)
    {
        $this->paypalActive = $paypalActive;

        return $this;
    }

    /**
     * Get paypalActive
     *
     * @return boolean 
     */
    public function getPaypalActive()
    {
        return $this->paypalActive;
    }

    /**
     * Set effectiveActive
     *
     * @param boolean $effectiveActive
     * @return SiteOption
     */
    public function setEffectiveActive($effectiveActive)
    {
        $this->effectiveActive = $effectiveActive;

        return $this;
    }

    /**
     * Get effectiveActive
     *
     * @return boolean 
     */
    public function getEffectiveActive()
    {
        return $this->effectiveActive;
    }

    /**
     * Set authServerSmtp
     *
     * @param string $authServerSmtp
     * @return SiteOption
     */
    public function setAuthServerSmtp($authServerSmtp)
    {
        $this->authServerSmtp = $authServerSmtp;

        return $this;
    }

    /**
     * Get authServerSmtp
     *
     * @return string 
     */
    public function getAuthServerSmtp()
    {
        return $this->authServerSmtp;
    }
}
