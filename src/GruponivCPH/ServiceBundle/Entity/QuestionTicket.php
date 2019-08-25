<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionTicket
 *
 * @ORM\Table(name="question_ticket")
 * @ORM\Entity(repositoryClass="GruponivCPH\ServiceBundle\Repository\QuestionTicketRepository")
 */
class QuestionTicket
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
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     */
    private $question;
    
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="questions")
     */
    private $ticket;
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="AnswerTicket", mappedBy="question", cascade={"remove"})
     */
    private $answer;
    
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

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
     * Set question
     *
     * @param string $question
     * @return QuestionTicket
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return QuestionTicket
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
     * Set ticket
     *
     * @param \GruponivCPH\ServiceBundle\Entity\Ticket $ticket
     * @return QuestionTicket
     */
    public function setTicket(\GruponivCPH\ServiceBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \GruponivCPH\ServiceBundle\Entity\Ticket 
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set answer
     *
     * @param \GruponivCPH\ServiceBundle\Entity\AnswerTicket $answer
     * @return QuestionTicket
     */
    public function setAnswer(\GruponivCPH\ServiceBundle\Entity\AnswerTicket $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    
    /**
     * Get answer
     *
     * @return \GruponivCPH\ServiceBundle\Entity\AnswerTicket 
     */
    public function getAnswer(){
        return $this->answer;
    }
    
}
