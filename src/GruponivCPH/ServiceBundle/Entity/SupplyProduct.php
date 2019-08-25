<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplyProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SupplyProduct
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
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="SupplyPayment")
     */
    private $supplyPayment;


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
     * Set product
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Product $product
     * @return SupplyProduct
     */
    public function setProduct(\GruponivCPH\ServiceBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set supplyPayment
     *
     * @param \GruponivCPH\ServiceBundle\Entity\SupplyPayment $supplyPayment
     * @return SupplyProduct
     */
    public function setSupplyPayment(\GruponivCPH\ServiceBundle\Entity\SupplyPayment $supplyPayment = null)
    {
        $this->supplyPayment = $supplyPayment;

        return $this;
    }

    /**
     * Get supplyPayment
     *
     * @return \GruponivCPH\ServiceBundle\Entity\SupplyPayment 
     */
    public function getSupplyPayment()
    {
        return $this->supplyPayment;
    }
}
