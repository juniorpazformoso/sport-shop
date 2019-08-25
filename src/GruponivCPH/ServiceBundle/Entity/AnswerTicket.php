<?php

namespace GruponivCPH\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AnswerTicket
 *
 * @ORM\Table(name="answer_ticket")
 * @ORM\Entity
 */
class AnswerTicket
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
     * @ORM\Column(name="answer", type="text")
     */
    private $answer;
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="QuestionTicket", inversedBy="answer")
     */
    private $question;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="GruponivCPH\UserBundle\Entity\User")
     */
    private $user;

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
     * Set answer
     *
     * @param string $answer
     * @return AnswerTicket
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return AnswerTicket
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
     * Set question
     *
     * @param \GruponivCPH\ServiceBundle\Entity\QuestionTicket $question
     * @return AnswerTicket
     */
    public function setQuestion(\GruponivCPH\ServiceBundle\Entity\QuestionTicket $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \GruponivCPH\ServiceBundle\Entity\QuestionTicket 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \GruponivCPH\UserBundle\Entity\User $user
     * @return AnswerTicket
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
}
