<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Test.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\EntityListeners({"AppBundle\EventListener\TestEntityListener"})
 */
class Test implements HasOwnerInterface
{
    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", length=300, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="300")
     */
    protected $title;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", length=500, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="500")
     */
    protected $description;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    protected $section;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    protected $timeLimit;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Range(min=1, max=100)
     */
    protected $passingScorePercent;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    protected $retakeTimeout;


    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @Assert\NotBlank(message="You can't create test without questions.")
     */
    protected $questions;

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
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Test
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set timeLimit
     *
     * @param integer $timeLimit
     *
     * @return Test
     */
    public function setTimeLimit($timeLimit)
    {
        $this->timeLimit = $timeLimit;

        return $this;
    }

    /**
     * Get timeLimit
     *
     * @return integer
     */
    public function getTimeLimit()
    {
        return $this->timeLimit;
    }

    /**
     * Set passingScorePercent
     *
     * @param integer $passingScorePercent
     *
     * @return Test
     */
    public function setPassingScorePercent($passingScorePercent)
    {
        $this->passingScorePercent = $passingScorePercent;

        return $this;
    }

    /**
     * Get passingScorePercent
     *
     * @return integer
     */
    public function getPassingScorePercent()
    {
        return $this->passingScorePercent;
    }

    /**
     * Set retakeTimeout
     *
     * @param integer $retakeTimeout
     *
     * @return Test
     */
    public function setRetakeTimeout($retakeTimeout)
    {
        $this->retakeTimeout = $retakeTimeout;

        return $this;
    }

    /**
     * Get retakeTimeout
     *
     * @return integer
     */
    public function getRetakeTimeout()
    {
        return $this->retakeTimeout;
    }

    /**
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Test
     */
    public function setSection(\AppBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return User[]
     */
    public function getOwners()
    {
        return [$this->getSection()->getCourse()->getUser()];
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Test
     * @ORM\PrePersist()
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = new \DateTime();

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

    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

}
