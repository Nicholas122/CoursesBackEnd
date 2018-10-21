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
class GradeTest
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
     * @ORM\ManyToOne(targetEntity="TestResult")
     * @ORM\JoinColumn(name="test_result_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $testResult;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $student;

    /**
     * @ORM\OneToMany(targetEntity="GradeQuestion", mappedBy="gradeTest")
     */
    protected $gradeQuestions;

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
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return GradeTest
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
     * Set teacher
     *
     * @param \AppBundle\Entity\User $teacher
     *
     * @return GradeTest
     */
    public function setTeacher(\AppBundle\Entity\User $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set student
     *
     * @param \AppBundle\Entity\User $student
     *
     * @return GradeTest
     */
    public function setStudent(\AppBundle\Entity\User $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \AppBundle\Entity\User
     */
    public function getStudent()
    {
        return $this->student;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gradeQuestions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add gradeQuestion
     *
     * @param \AppBundle\Entity\GradeQuestion $gradeQuestion
     *
     * @return GradeTest
     */
    public function addGradeQuestion(\AppBundle\Entity\GradeQuestion $gradeQuestion)
    {
        $this->gradeQuestions[] = $gradeQuestion;

        return $this;
    }

    /**
     * Remove gradeQuestion
     *
     * @param \AppBundle\Entity\GradeQuestion $gradeQuestion
     */
    public function removeGradeQuestion(\AppBundle\Entity\GradeQuestion $gradeQuestion)
    {
        $this->gradeQuestions->removeElement($gradeQuestion);
    }

    /**
     * Get gradeQuestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGradeQuestions()
    {
        return $this->gradeQuestions;
    }

    /**
     * Set testResult
     *
     * @param \AppBundle\Entity\TestResult $testResult
     *
     * @return GradeTest
     */
    public function setTestResult(\AppBundle\Entity\TestResult $testResult = null)
    {
        $this->testResult = $testResult;

        return $this;
    }

    /**
     * Get testResult
     *
     * @return \AppBundle\Entity\TestResult
     */
    public function getTestResult()
    {
        return $this->testResult;
    }
}
