<?php
namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    

    

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="submenus")
     * @ORM\JoinColumn(name="belong", referencedColumnName="id", nullable=true)
     */
    private $belong;

    
    

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
    }
    

    

    public function __toString()
    {
        return $this->getTitle();
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
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set belong
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Category $belong
     * @return Category
     */
    public function setBelong(\GruponivCPH\ServiceBundle\Entity\Category $belong = null)
    {
        $this->belong = $belong;

        return $this;
    }

    /**
     * Get belong
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Category 
     */
    public function getBelong()
    {
        return $this->belong;
    }

    

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
