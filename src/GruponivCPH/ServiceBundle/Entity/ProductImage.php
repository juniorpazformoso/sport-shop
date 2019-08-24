<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductImage
 *
 * @ORM\Table(name="productimage")
 * @ORM\Entity(repositoryClass="GruponivCPH\ServiceBundle\Repository\ProductImageRepository")
 */
class ProductImage
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productImages")
     */
    private $product; 
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set image
     *
     * @param string $image
     * @return ProductImage
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set product
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Product $product
     * @return ProductImage
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
}
