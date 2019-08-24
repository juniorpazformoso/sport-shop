<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddressClient
 *
 * @ORM\Table(name="addressclient")
 * @ORM\Entity
 */
class AddressClient
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
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="address")
     */
    private $client;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="enterprise", type="string", length=255, nullable=true)
     */
    private $enterprise;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=255)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;
    
    

    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Country")
     */
    private $country;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Province")
     */
    private $province;
    
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Community")
     */
    private $community;


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
     * Set address
     *
     * @param string $address
     * @return AddressClient
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return AddressClient
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
     * @return AddressClient
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
     * @return AddressClient
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
     * Set client
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Client $client
     * @return AddressClient
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
     * Constructor
     */
    public function __construct()
    {
        $this->client = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add client
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Client $client
     * @return AddressClient
     */
    public function addClient(\GruponivCPH\ServiceBundle\Entity\Client $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Client $client
     */
    public function removeClient(\GruponivCPH\ServiceBundle\Entity\Client $client)
    {
        $this->client->removeElement($client);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AddressClient
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
     * Set town
     *
     * @param string $town
     * @return AddressClient
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set enterprise
     *
     * @param string $enterprise
     * @return AddressClient
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * Get enterprise
     *
     * @return string 
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return AddressClient
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return AddressClient
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set province
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Province $province
     * @return AddressClient
     */
    public function setProvince(\GruponivCPH\ServiceBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Province 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set community
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Community $community
     * @return AddressClient
     */
    public function setCommunity(\GruponivCPH\ServiceBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }
}
