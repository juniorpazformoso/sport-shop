<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FreeShippingCountry
 *
 * @ORM\Table(name="countrysend")
 * @ORM\Entity
 * @UniqueEntity(fields="country", message="Ya existe un envío para este país")
 */
class CountrySend
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="pricefree", type="float")
     */
    private $pricefree;
    
    
    
    /**
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Country")
     */
    private $country;


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
     * Set price
     *
     * @param float $price
     * @return FreeShippingCountry
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    

    /**
     * Set active
     *
     * @param boolean $active
     * @return FreeShippingCountry
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

    /**
     * Set country
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Country $country
     * @return FreeShippingCountry
     */
    public function setCountry(\GruponivCPH\ServiceBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set pricefree
     *
     * @param float $pricefree
     * @return CountrySend
     */
    public function setPricefree($pricefree)
    {
        $this->pricefree = $pricefree;

        return $this;
    }

    /**
     * Get pricefree
     *
     * @return float 
     */
    public function getPricefree()
    {
        return $this->pricefree;
    }
}
