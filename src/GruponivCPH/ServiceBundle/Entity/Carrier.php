<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 
 * 
 * @ORM\Table(name="carrier")
 * @ORM\Entity
 */
class Carrier
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
     * @ORM\Column(name="transitTime", type="string", length=255)
     */
    private $transitTime;

    /**
     * @var string
     *
     * @ORM\Column(name="speedRating", type="string", length=255)
     */
    private $speedRating;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="urlTracking", type="string", length=255)
     */
    private $urlTracking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="freeShipping", type="boolean")
     */
    private $freeShipping;
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="TaxZone")
     */
    private $taxZone;
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="TaxCountry")
     */
    private $taxCountry;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="billing", type="string", length=255)
     */
    private $billing;
    
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="maximumPackageHeight", type="string", length=255)
     */
    private $maximumPackageHeight;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="maximumPackageWidth", type="string", length=255)
     */
    private $maximumPackageWidth;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="maximumDepthPackage", type="string", length=255)
     */
    private $maximumDepthPackage;

    
    /**
     * @var string
     *
     * @ORM\Column(name="maximumPackageWeight", type="string", length=255)
     */
    private $maximumPackageWeight;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    private $logoFile;
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setLogoFile(UploadedFile $logoFile = null)
    {
        $this->logoFile = $logoFile;
    }
    
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }
    
    
    /**
     * Set name
     *
     * @param string $name
     * @return Carrier
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
     * Set transitTime
     *
     * @param string $transitTime
     * @return Carrier
     */
    public function setTransitTime($transitTime)
    {
        $this->transitTime = $transitTime;

        return $this;
    }

    /**
     * Get transitTime
     *
     * @return string 
     */
    public function getTransitTime()
    {
        return $this->transitTime;
    }

    /**
     * Set speedRating
     *
     * @param string $speedRating
     * @return Carrier
     */
    public function setSpeedRating($speedRating)
    {
        $this->speedRating = $speedRating;

        return $this;
    }

    /**
     * Get speedRating
     *
     * @return string 
     */
    public function getSpeedRating()
    {
        return $this->speedRating;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Carrier
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set urlTracking
     *
     * @param string $urlTracking
     * @return Carrier
     */
    public function setUrlTracking($urlTracking)
    {
        $this->urlTracking = $urlTracking;

        return $this;
    }

    /**
     * Get urlTracking
     *
     * @return string 
     */
    public function getUrlTracking()
    {
        return $this->urlTracking;
    }

    /**
     * Set freeShipping
     *
     * @param boolean $freeShipping
     * @return Carrier
     */
    public function setFreeShipping($freeShipping)
    {
        $this->freeShipping = $freeShipping;

        return $this;
    }

    /**
     * Get freeShipping
     *
     * @return boolean 
     */
    public function getFreeShipping()
    {
        return $this->freeShipping;
    }

    /**
     * Set billing
     *
     * @param boolean $billing
     * @return Carrier
     */
    public function setBilling($billing)
    {
        $this->billing = $billing;

        return $this;
    }

    /**
     * Get billing
     *
     * @return boolean 
     */
    public function getBilling()
    {
        return $this->billing;
    }

    /**
     * Set maximumPackageHeight
     *
     * @param string $maximumPackageHeight
     * @return Carrier
     */
    public function setMaximumPackageHeight($maximumPackageHeight)
    {
        $this->maximumPackageHeight = $maximumPackageHeight;

        return $this;
    }

    /**
     * Get maximumPackageHeight
     *
     * @return string 
     */
    public function getMaximumPackageHeight()
    {
        return $this->maximumPackageHeight;
    }

    /**
     * Set maximumPackageWidth
     *
     * @param string $maximumPackageWidth
     * @return Carrier
     */
    public function setMaximumPackageWidth($maximumPackageWidth)
    {
        $this->maximumPackageWidth = $maximumPackageWidth;

        return $this;
    }

    /**
     * Get maximumPackageWidth
     *
     * @return string 
     */
    public function getMaximumPackageWidth()
    {
        return $this->maximumPackageWidth;
    }

    /**
     * Set maximumDepthPackage
     *
     * @param string $maximumDepthPackage
     * @return Carrier
     */
    public function setMaximumDepthPackage($maximumDepthPackage)
    {
        $this->maximumDepthPackage = $maximumDepthPackage;

        return $this;
    }

    /**
     * Get maximumDepthPackage
     *
     * @return string 
     */
    public function getMaximumDepthPackage()
    {
        return $this->maximumDepthPackage;
    }

    /**
     * Set maximumPackageWeight
     *
     * @param string $maximumPackageWeight
     * @return Carrier
     */
    public function setMaximumPackageWeight($maximumPackageWeight)
    {
        $this->maximumPackageWeight = $maximumPackageWeight;

        return $this;
    }

    /**
     * Get maximumPackageWeight
     *
     * @return string 
     */
    public function getMaximumPackageWeight()
    {
        return $this->maximumPackageWeight;
    }

    /**
     * Set taxZone
     *
     * @param \GruponivCPH\ServiceBundle\Entity\TaxZone $taxZone
     * @return Carrier
     */
    public function setTaxZone(\GruponivCPH\ServiceBundle\Entity\TaxZone $taxZone = null)
    {
        $this->taxZone = $taxZone;

        return $this;
    }

    /**
     * Get taxZone
     *
     * @return \GruponivCPH\ServiceBundle\Entity\TaxZone 
     */
    public function getTaxZone()
    {
        return $this->taxZone;
    }

    /**
     * Set taxCountry
     *
     * @param \GruponivCPH\ServiceBundle\Entity\TaxCountry $taxCountry
     * @return Carrier
     */
    public function setTaxCountry(\GruponivCPH\ServiceBundle\Entity\TaxCountry $taxCountry = null)
    {
        $this->taxCountry = $taxCountry;

        return $this;
    }

    /**
     * Get taxCountry
     *
     * @return \GruponivCPH\ServiceBundle\Entity\TaxCountry 
     */
    public function getTaxCountry()
    {
        return $this->taxCountry;
    }
}
