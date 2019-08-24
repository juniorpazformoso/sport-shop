<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrderClient
 *
 * @ORM\Table(name="order_client")
 * @ORM\Entity(repositoryClass="GruponivCPH\ServiceBundle\Repository\OrderClientRepository")
 */
class OrderClient
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
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;
    
    
    /**
     * @ORM\Column(name="txn_id", type="string", length=255, nullable=true)
     */
    private $txn_id;
    

    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="orderClients")
     */
    private $client;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="postalCode", type="string", length=255)
     */
    private $postalCode;

    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;
    
    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="paymentMethod", type="string", length=255, nullable=true)
     */
    private $paymentMethod;
    
    
    
    /**
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status = "Pendiente";
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OrderClientProduct", mappedBy="orderClient", cascade={"remove"})
     */
    private $products;
    
    

    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="mobilePhone", type="string", length=255)
     */
    private $mobilePhone;

    
    
    /**
     * @var string
     * @Assert\NotBlank(message = "El campo no puede estar en blanco")
     * @ORM\Column(name="landline", type="string", length=255)
     */
    private $landline;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return OrderClient
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return OrderClient
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return OrderClient
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return OrderClient
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return OrderClient
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return OrderClient
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     * @return OrderClient
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set landline
     *
     * @param string $landline
     * @return OrderClient
     */
    public function setLandline($landline)
    {
        $this->landline = $landline;

        return $this;
    }

    /**
     * Get landline
     *
     * @return string 
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * Set client
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Client $client
     * @return OrderClient
     */
    public function setClient(\GruponivCPH\ServiceBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add products
     *
     * @param \GruponivCPH\ServiceBundle\Entity\OrderClientProduct $products
     * @return OrderClient
     */
    public function addProduct(\GruponivCPH\ServiceBundle\Entity\OrderClientProduct $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \GruponivCPH\ServiceBundle\Entity\OrderClientProduct $products
     */
    public function removeProduct(\GruponivCPH\ServiceBundle\Entity\OrderClientProduct $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return OrderClient
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return OrderClient
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set txn_id
     *
     * @param string $txnId
     * @return OrderClient
     */
    public function setTxnId($txnId)
    {
        $this->txn_id = $txnId;

        return $this;
    }

    /**
     * Get txn_id
     *
     * @return string 
     */
    public function getTxnId()
    {
        return $this->txn_id;
    }
}
