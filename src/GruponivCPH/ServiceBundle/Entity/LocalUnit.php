<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocalUnit
 *
 * @ORM\Table(name="localunit")
 * @ORM\Entity
 */
class LocalUnit
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
     * @ORM\Column(name="weightUnit", type="string", length=255)
     */
    private $weightUnit;

    /**
     * @var float
     *
     * @ORM\Column(name="distanceUnit", type="string", length=255)
     */
    private $distanceUnit;

    /**
     * @var float
     *
     * @ORM\Column(name="volumenUnit", type="string", length=255)
     */
    private $volumenUnit;

    /**
     * @var float
     *
     * @ORM\Column(name="dimensionUnit", type="string", length=255)
     */
    private $dimensionUnit;


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
     * Set weightUnit
     *
     * @param float $weightUnit
     * @return LocalUnit
     */
    public function setWeightUnit($weightUnit)
    {
        $this->weightUnit = $weightUnit;

        return $this;
    }

    /**
     * Get weightUnit
     *
     * @return float 
     */
    public function getWeightUnit()
    {
        return $this->weightUnit;
    }

    /**
     * Set distanceUnit
     *
     * @param float $distanceUnit
     * @return LocalUnit
     */
    public function setDistanceUnit($distanceUnit)
    {
        $this->distanceUnit = $distanceUnit;

        return $this;
    }

    /**
     * Get distanceUnit
     *
     * @return float 
     */
    public function getDistanceUnit()
    {
        return $this->distanceUnit;
    }

    /**
     * Set volumenUnit
     *
     * @param float $volumenUnit
     * @return LocalUnit
     */
    public function setVolumenUnit($volumenUnit)
    {
        $this->volumenUnit = $volumenUnit;

        return $this;
    }

    /**
     * Get volumenUnit
     *
     * @return float 
     */
    public function getVolumenUnit()
    {
        return $this->volumenUnit;
    }

    /**
     * Set dimensionUnit
     *
     * @param float $dimensionUnit
     * @return LocalUnit
     */
    public function setDimensionUnit($dimensionUnit)
    {
        $this->dimensionUnit = $dimensionUnit;

        return $this;
    }

    /**
     * Get dimensionUnit
     *
     * @return float 
     */
    public function getDimensionUnit()
    {
        return $this->dimensionUnit;
    }
}
