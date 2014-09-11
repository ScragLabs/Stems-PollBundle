<?php
namespace Stems\PollBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Stems\CoreBundle\Definition\SectionInstanceInterface;

/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_poll_section_poll")
 */
class SectionPoll implements SectionInstanceInterface
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /** 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $poll;

    /**
     * Build the html for rendering in the front end, using any nessary custom code
     *
     * @param  Sections     $services   The section management service
     * @param  Section      $link       The section link entity
     * @return string                   The html of the rendered section
     */
    public function render($services, $link)
    {
        // Render the twig template
        return $services->getTwig()->render('StemsPollBundle:Section:poll.html.twig', array(
            'section'   => $this,
            'link'      => $link,
        ));
    }

    /**
     * Build the html for admin editor form
     *
     * @param  Sections     $services   The section management service
     * @param  Section      $link       The section link entity
     * @return string                   The html of the rendered section form
     */
    public function editor($services, $link)
    {
        // Build the section from using the generic builder method
        $form = $services->createSectionForm($link, $this);

        // Render the admin form html
        return $services->getTwig()->render('StemsPollBundle:Section:pollForm.html.twig', array(
            'form'      => $form->createView(),
            'section'   => $this,
            'link'      => $link,
        ));
    }

    /**
     * Update the section from posted data
     *
     * @param  Sections     $services       The section management service
     * @param  array        $parameters     A collection of parameters to save against the entity
     * @param  Request      $request        
     * @param  Section      $link           The section link entity
     */
    public function save($services, $parameters, $request, $link)
    {
        // Save the values
        $this->setContent($parameters['content']);

        $services->getManager()->persist($this);
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
     * Set content
     *
     * @param string $content
     * @return Section
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set poll
     *
     * @param integer $poll
     * @return Section
     */
    public function setPoll($poll)
    {
        $this->poll = $poll;
    
        return $this;
    }

    /**
     * Get poll
     *
     * @return integer 
     */
    public function getPoll()
    {
        return $this->poll;
    }
}