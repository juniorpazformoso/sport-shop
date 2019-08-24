<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="GruponivCPH\ServiceBundle\Repository\ClientRepository")
 * @UniqueEntity(fields="email", message="Una cuenta ya está registrada con este e-mail.")
 */
class Client
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
     * @Assert\NotBlank(message = "No puede estar en blanco")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message = "No puede estar en blanco")
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    
    
    /**
     * @ORM\Column(name="dni_nif", type="string", length=255, nullable=true)
     */
    private $dni_nif;

    
    /**
     * @var string
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;
    
    
    /**
     * @Assert\NotBlank(message = "No puede estar en blanco")
     * @ORM\ManyToOne(targetEntity="Gender")
     */
    private $gender;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="GruponivCPH\UserBundle\Entity\User", cascade={"remove"})
     */
    private $user;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="client", cascade={"remove"})
     */
    private $tickets;   
    

    /**
     * @var string
     * @Assert\NotBlank(message = "No puede estar en blanco")
     * @Assert\Email(message = "Indique un correo valido")
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="storage", type="string", length=255)
     */
    private $storage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="AddressClient", mappedBy="client", cascade={"remove"})
     */
    private $address;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OrderClient", mappedBy="client", cascade={"remove"})
     */
    private $orderClients;


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
     * @return Client
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
     * Set lastName
     *
     * @param string $lastName
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    

    /**
     * Set email
     *
     * @param string $email
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Client
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set storage
     *
     * @param string $storage
     * @return Client
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get storage
     *
     * @return string 
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Client
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
     * Set age
     *
     * @param integer $age
     * @return Client
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Gender $gender
     * @return Client
     */
    public function setGender(\GruponivCPH\ServiceBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Gender 
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->address = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add address
     *
     * @param \GruponivCPH\ServiceBundle\Entity\AddressClient $address
     * @return Client
     */
    public function addAddress(\GruponivCPH\ServiceBundle\Entity\AddressClient $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \GruponivCPH\ServiceBundle\Entity\AddressClient $address
     */
    public function removeAddress(\GruponivCPH\ServiceBundle\Entity\AddressClient $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user
     *
     * @param \GruponivCPH\UserBundle\Entity\User $user
     * @return Client
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
     * Add orderClients
     *
     * @param \GruponivCPH\ServiceBundle\Entity\OrderClient $orderClients
     * @return Client
     */
    public function addOrderClient(\GruponivCPH\ServiceBundle\Entity\OrderClient $orderClients)
    {
        $this->orderClients[] = $orderClients;

        return $this;
    }

    /**
     * Remove orderClients
     *
     * @param \GruponivCPH\ServiceBundle\Entity\OrderClient $orderClients
     */
    public function removeOrderClient(\GruponivCPH\ServiceBundle\Entity\OrderClient $orderClients)
    {
        $this->orderClients->removeElement($orderClients);
    }

    /**
     * Get orderClients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderClients()
    {
        return $this->orderClients;
    }

    /**
     * Add tickets
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Ticket $tickets
     * @return Client
     */
    public function addTicket(\GruponivCPH\ServiceBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;

        return $this;
    }

    /**
     * Remove tickets
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Ticket $tickets
     */
    public function removeTicket(\GruponivCPH\ServiceBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }
    

    public function __toString() {
        return $this->name . " " . $this->lastName;
    }

    /**
     * Set dni_nif
     *
     * @param string $dniNif
     * @return Client
     */
    public function setDniNif($dniNif)
    {
        $this->dni_nif = $dniNif;

        return $this;
    }

    /**
     * Get dni_nif
     *
     * @return string 
     */
    public function getDniNif()
    {
        return $this->dni_nif;
    }
}
