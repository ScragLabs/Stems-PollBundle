<?php

namespace Stems\PollBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity()
 * @ORM\Table(name="stm_poll_vote")
 */
class Vote
{
	/** 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** 
	 * @ORM\Column(type="string", length=39)
	 * @Assert\Ip()
	 */
	protected $ip;

	/** 
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @ORM\ManyToOne(targetEntity="Choice", inversedBy="votes")
	 * @ORM\JoinColumn(name="choice_id", referencedColumnName="id")
	 */
	protected $choice;

    /**
     * Constructor
     */
    public function __construct($choice=null, $ip=null)
    {
        if ($choice) {
            $this->choice = $choice;
            $this->ip     = $ip;
        }
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
     * Set ip
     *
     * @param string $ip
     * @return Vote
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Vote
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set choice
     *
     * @param \Stems\PollBundle\Entity\Choice $choice
     * @return Vote
     */
    public function setChoice(\Stems\PollBundle\Entity\Choice $choice = null)
    {
        $this->choice = $choice;
    
        return $this;
    }

    /**
     * Get choice
     *
     * @return \Stems\PollBundle\Entity\Choice 
     */
    public function getChoice()
    {
        return $this->choice;
    }
}