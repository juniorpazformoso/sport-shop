<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderClientProduct
 *
 * @ORM\Table(name="order_client_product")
 * @ORM\Entity
 */
class OrderClientProduct
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

    
    /**
     * @var string
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="OrderClient", inversedBy="products")
     */
    private $orderClient;
    
    
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
     * Set count
     *
     * @param integer $count
     * @return OrderClientProduct
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set product
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Product $product
     * @return OrderClientProduct
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
     * Set orderClient
     *
     * @param \GruponivCPH\ServiceBundle\Entity\OrderClient $orderClient
     * @return OrderClientProduct
     */
    public function setOrderClient(\GruponivCPH\ServiceBundle\Entity\OrderClient $orderClient = null)
    {
        $this->orderClient = $orderClient;

        return $this;
    }

    /**
     * Get orderClient
     *
     * @return \GruponivCPH\ServiceBundle\Entity\OrderClient 
     */
    public function getOrderClient()
    {
        return $this->orderClient;
    }
}
