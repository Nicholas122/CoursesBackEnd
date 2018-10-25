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
class StartedTest implements HasOwnerInterface
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
     * @ORM\Column(type="datetime");
     */
   protected $startedDate;

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
     * Set startedDate
     *
     * @param \DateTime $startedDate
     *
     * @return StartedTest
     * @ORM\PrePersist()
     */
    public function setStartedDate($startedDate)
    {
        $this->startedDate = new \DateTime();

        return $this;
    }

    /**
     * Get startedDate
     *
     * @return \DateTime
     */
    public function getStartedDate()
    {
        return $this->startedDate;
    }

    /**
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return StartedTest
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
     * @return StartedTest
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
     * @return User[]
     */
    public function getOwners()
    {
        return [$this->getUser()];
    }
}
