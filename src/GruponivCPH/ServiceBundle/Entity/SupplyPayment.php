<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplyPayment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SupplyPayment
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
     * @ORM\ManyToOne(targetEntity="Provider")
     */
    private $provider;
    
    
    /**
     *
     * @ORM\Column(name="dateSupply", type="datetime")
     */
    private $dateSupply;


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
     * Set dateSupply
     *
     * @param \DateTime $dateSupply
     * @return SupplyPayment
     */
    public function setDateSupply($dateSupply)
    {
        $this->dateSupply = $dateSupply;

        return $this;
    }

    /**
     * Get dateSupply
     *
     * @return \DateTime 
     */
    public function getDateSupply()
    {
        return $this->dateSupply;
    }

    /**
     * Set provider
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Provider $provider
     * @return SupplyPayment
     */
    public function setProvider(\GruponivCPH\ServiceBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Provider 
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
