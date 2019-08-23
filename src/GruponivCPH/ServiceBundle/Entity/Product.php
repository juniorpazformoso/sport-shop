<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="GruponivCPH\ServiceBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;
    
    
    /**
     *
     * @ORM\Column(name="ranking", type="string", length=255)
     */
    private $ranking;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="basePrice", type="float")
     */
    private $basePrice;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sectionProduct", type="string", length=255)
     */
    private $sectionProduct;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="text")
     */
    private $shortDescription;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product", cascade={"remove"})
     */
    private $productImages;
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Category")
     */
    private $categories;
    
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Product")
     */
    private $relateProduct;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="visibleInHome", type="boolean")
     */
    private $visibleInHome;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="imageHover", type="string", length=255)
     */
    private $imageHover;
    
    
    private $pictureFile;
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setPictureFile(UploadedFile $pictureFile = null)
    {
        $this->pictureFile = $pictureFile;
    }
    
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }
    
    
    
    
    private $pictureHoverFile;
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setPictureHoverFile(UploadedFile $pictureHoverFile = null)
    {
        $this->pictureHoverFile = $pictureHoverFile;
    }
    
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getPictureHoverFile()
    {
        return $this->pictureHoverFile;
    }


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
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
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
     * Set imageHover
     *
     * @param string $imageHover
     * @return Product
     */
    public function setImageHover($imageHover)
    {
        $this->imageHover = $imageHover;

        return $this;
    }

    /**
     * Get imageHover
     *
     * @return string 
     */
    public function getImageHover()
    {
        return $this->imageHover;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->relateProduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add relateProduct
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Product $relateProduct
     * @return Product
     */
    public function addRelateProduct(\GruponivCPH\ServiceBundle\Entity\Product $relateProduct)
    {
        $this->relateProduct[] = $relateProduct;

        return $this;
    }

    /**
     * Remove relateProduct
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Product $relateProduct
     */
    public function removeRelateProduct(\GruponivCPH\ServiceBundle\Entity\Product $relateProduct)
    {
        $this->relateProduct->removeElement($relateProduct);
    }

    /**
     * Get relateProduct
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelateProduct()
    {
        return $this->relateProduct;
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * Add productImages
     *
     * @param \GruponivCPH\ServiceBundle\Entity\ProductImage $productImages
     * @return Product
     */
    public function addProductImage(\GruponivCPH\ServiceBundle\Entity\ProductImage $productImages)
    {
        $this->productImages[] = $productImages;

        return $this;
    }

    /**
     * Remove productImages
     *
     * @param \GruponivCPH\ServiceBundle\Entity\ProductImage $productImages
     */
    public function removeProductImage(\GruponivCPH\ServiceBundle\Entity\ProductImage $productImages)
    {
        $this->productImages->removeElement($productImages);
    }

    /**
     * Get productImages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductImages()
    {
        return $this->productImages;
    }

    /**
     * Add categories
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategory(\GruponivCPH\ServiceBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Category $categories
     */
    public function removeCategory(\GruponivCPH\ServiceBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Product
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Product
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set visibleInHome
     *
     * @param boolean $visibleInHome
     * @return Product
     */
    public function setVisibleInHome($visibleInHome)
    {
        $this->visibleInHome = $visibleInHome;

        return $this;
    }

    /**
     * Get visibleInHome
     *
     * @return boolean 
     */
    public function getVisibleInHome()
    {
        return $this->visibleInHome;
    }

    /**
     * Set argentinaLine
     *
     * @param boolean $argentinaLine
     * @return Product
     */
    public function setArgentinaLine($argentinaLine)
    {
        $this->argentinaLine = $argentinaLine;

        return $this;
    }

    /**
     * Get argentinaLine
     *
     * @return boolean 
     */
    public function getArgentinaLine()
    {
        return $this->argentinaLine;
    }

    /**
     * Set paloHockey
     *
     * @param boolean $paloHockey
     * @return Product
     */
    public function setPaloHockey($paloHockey)
    {
        $this->paloHockey = $paloHockey;

        return $this;
    }

    /**
     * Get paloHockey
     *
     * @return boolean 
     */
    public function getPaloHockey()
    {
        return $this->paloHockey;
    }

    /**
     * Set palaExclusive
     *
     * @param boolean $palaExclusive
     * @return Product
     */
    public function setPalaExclusive($palaExclusive)
    {
        $this->palaExclusive = $palaExclusive;

        return $this;
    }

    /**
     * Get palaExclusive
     *
     * @return boolean 
     */
    public function getPalaExclusive()
    {
        return $this->palaExclusive;
    }

    /**
     * Set sectionProduct
     *
     * @param string $sectionProduct
     * @return Product
     */
    public function setSectionProduct($sectionProduct)
    {
        $this->sectionProduct = $sectionProduct;

        return $this;
    }

    /**
     * Get sectionProduct
     *
     * @return string 
     */
    public function getSectionProduct()
    {
        return $this->sectionProduct;
    }

    

    /**
     * Set price
     *
     * @param float $price
     * @return Product
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
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Product
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set ranking
     *
     * @param string $ranking
     * @return Product
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get ranking
     *
     * @return string 
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Set basePrice
     *
     * @param float $basePrice
     * @return Product
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return float 
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Product
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
     * Set ref
     *
     * @param string $ref
     * @return Product
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }
}
