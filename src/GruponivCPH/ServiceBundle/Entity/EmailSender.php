<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailSender
 *
 * @ORM\Table(name="emailsender")
 * @ORM\Entity
 */
class EmailSender
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=255)
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\Column(name="colorBase", type="string", length=255)
     */
    private $colorBase;

    /**
     * @var string
     *
     * @ORM\Column(name="colorBackground", type="string", length=255)
     */
    private $colorBackground;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundColorBody", type="string", length=255)
     */
    private $backgroundColorBody;

    /**
     * @var string
     *
     * @ORM\Column(name="textColorBody", type="string", length=255)
     */
    private $textColorBody;

    /**
     * @var string
     *
     * @ORM\Column(name="textPage", type="text")
     */
    private $textPage;


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
     * @return EmailSender
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
     * Set sender
     *
     * @param string $sender
     * @return EmailSender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set colorBase
     *
     * @param string $colorBase
     * @return EmailSender
     */
    public function setColorBase($colorBase)
    {
        $this->colorBase = $colorBase;

        return $this;
    }

    /**
     * Get colorBase
     *
     * @return string 
     */
    public function getColorBase()
    {
        return $this->colorBase;
    }

    /**
     * Set colorBackground
     *
     * @param string $colorBackground
     * @return EmailSender
     */
    public function setColorBackground($colorBackground)
    {
        $this->colorBackground = $colorBackground;

        return $this;
    }

    /**
     * Get colorBackground
     *
     * @return string 
     */
    public function getColorBackground()
    {
        return $this->colorBackground;
    }

    /**
     * Set backgroundColorBody
     *
     * @param string $backgroundColorBody
     * @return EmailSender
     */
    public function setBackgroundColorBody($backgroundColorBody)
    {
        $this->backgroundColorBody = $backgroundColorBody;

        return $this;
    }

    /**
     * Get backgroundColorBody
     *
     * @return string 
     */
    public function getBackgroundColorBody()
    {
        return $this->backgroundColorBody;
    }

    /**
     * Set textColorBody
     *
     * @param string $textColorBody
     * @return EmailSender
     */
    public function setTextColorBody($textColorBody)
    {
        $this->textColorBody = $textColorBody;

        return $this;
    }

    /**
     * Get textColorBody
     *
     * @return string 
     */
    public function getTextColorBody()
    {
        return $this->textColorBody;
    }

    /**
     * Set textPage
     *
     * @param string $textPage
     * @return EmailSender
     */
    public function setTextPage($textPage)
    {
        $this->textPage = $textPage;

        return $this;
    }

    /**
     * Get textPage
     *
     * @return string 
     */
    public function getTextPage()
    {
        return $this->textPage;
    }
}
