<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Test.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class TestResult implements HasOwnerInterface
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
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $test;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="QuestionResult", mappedBy="testResult")
     */
    protected $questionResults;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="float")
     */
    protected $result;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $passDate;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionResults = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set result
     *
     * @param float $result
     *
     * @return TestResult
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return float
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set passDate
     *
     * @param \DateTime $passDate
     *
     * @return TestResult
     * @ORM\PrePersist()
     */
    public function setPassDate($passDate)
    {
        $this->passDate = new \DateTime();

        return $this;
    }

    /**
     * Get passDate
     *
     * @return \DateTime
     */
    public function getPassDate()
    {
        return $this->passDate;
    }

    /**
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return TestResult
     */
    public function setTest(\AppBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \AppBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return TestResult
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add questionResult
     *
     * @param \AppBundle\Entity\QuestionResult $questionResult
     *
     * @return TestResult
     */
    public function addQuestionResult(\AppBundle\Entity\QuestionResult $questionResult)
    {
        $this->questionResults[] = $questionResult;

        return $this;
    }

    /**
     * Remove questionResult
     *
     * @param \AppBundle\Entity\QuestionResult $questionResult
     */
    public function removeQuestionResult(\AppBundle\Entity\QuestionResult $questionResult)
    {
        $this->questionResults->removeElement($questionResult);
    }

    /**
     * Get questionResults
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionResults()
    {
        return $this->questionResults;
    }

    /**
     * @return User[]
     */
    public function getOwners()
    {
        return [$this->getUser()];
    }
}
