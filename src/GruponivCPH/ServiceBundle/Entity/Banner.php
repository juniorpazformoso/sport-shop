<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Banner
 *
 * @ORM\Table(name="banner")
 * @ORM\Entity
 */
class Banner
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
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;
    
    
    
    /**
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    
    
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
     * @return Banner
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
     * Set status
     *
     * @param boolean $status
     * @return Banner
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set category
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Category $category
     * @return Banner
     */
    public function setCategory(\GruponivCPH\ServiceBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Banner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
