<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;    

    
    /**
     * @var string
     *
     * @ORM\Column(name="subjet", type="string", length=255)
     */
    private $subjet;
    
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="QuestionTicket", mappedBy="ticket", cascade={"remove"})
     */
    private $questions;
    
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state = "En espera de respuesta";
    
        
    /**
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="tickets")
     */
    private $client;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Ticket
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Ticket
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set subjet
     *
     * @param string $subjet
     * @return Ticket
     */
    public function setSubjet($subjet)
    {
        $this->subjet = $subjet;

        return $this;
    }

    /**
     * Get subjet
     *
     * @return string 
     */
    public function getSubjet()
    {
        return $this->subjet;
    }

    
    /**
     * Set state
     *
     * @param string $state
     * @return Ticket
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add questions
     *
     * @param \GruponivCPH\ServiceBundle\Entity\QuestionTicket $questions
     * @return Ticket
     */
    public function addQuestion(\GruponivCPH\ServiceBundle\Entity\QuestionTicket $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \GruponivCPH\ServiceBundle\Entity\QuestionTicket $questions
     */
    public function removeQuestion(\GruponivCPH\ServiceBundle\Entity\QuestionTicket $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set user
     *
     * @param \GruponivCPH\UserBundle\Entity\User $user
     * @return Ticket
     */
    public function setUser(\GruponivCPH\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GruponivCPH\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set client
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Client $client
     * @return Ticket
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
}
