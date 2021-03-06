<?php

namespace Stems\PollBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity()
 * @ORM\Table(name="stm_poll_choice")
 */
class Choice
{
	/** 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** 
	 * @ORM\Column(type="string", length=255)
	 */
	protected $label;

	/**
	 * @ORM\ManyToOne(targetEntity="Poll", inversedBy="choices")
	 * @ORM\JoinColumn(name="poll_id", referencedColumnName="id")
	 */
	protected $poll;

	/**
	 * @ORM\OneToMany(targetEntity="Vote", mappedBy="choice")
	 */
	protected $votes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get percentage
     *
     * @return integer 
     */
    public function getPercentage()
    {
        $total = 0;

        foreach ($this->getPoll()->getChoices() as $choice) {
            $total += count($choice->getVotes());
        }

        $percentage = (count($this->getVotes()) / $total) * 100;

        return round($percentage);
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
     * Set label
     *
     * @param string $label
     * @return Choice
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set poll
     *
     * @param \Stems\PollBundle\Entity\Poll $poll
     * @return poll
     */
    public function setPoll(\Stems\PollBundle\Entity\Poll $poll = null)
    {
        $this->poll = $poll;
    
        return $this;
    }

    /**
     * Get poll
     *
     * @return \Stems\PollBundle\Entity\Poll 
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * Add votes
     *
     * @param \Stems\PollBundle\Entity\Vote $votes
     * @return Choice
     */
    public function addVote(\Stems\PollBundle\Entity\Vote $votes)
    {
        $this->votes[] = $votes;
    
        return $this;
    }

    /**
     * Remove votes
     *
     * @param \Stems\PollBundle\Entity\Vote $votes
     */
    public function removeVote(\Stems\PollBundle\Entity\Vote $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }
}