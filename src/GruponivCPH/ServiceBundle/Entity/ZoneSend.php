<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FreeShippingZone
 *
 * @ORM\Table(name="zonesend")
 * @ORM\Entity
 */
class ZoneSend
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
     * @ORM\ManyToOne(targetEntity="Zone")
     */
    private $zone;
    
    
    
    /**
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
     * Set price
     *
     * @param float $price
     * @return FreeShippingZone
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
     * @return FreeShippingZone
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
     * Set pricefree
     *
     * @param float $pricefree
     * @return ZoneSend
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

    /**
     * Set zone
     *
     * @param string $zone
     * @return ZoneSend
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string 
     */
    public function getZone()
    {
        return $this->zone;
    }
}
