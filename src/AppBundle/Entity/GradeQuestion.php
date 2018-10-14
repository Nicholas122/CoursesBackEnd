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
class GradeQuestion
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
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $question;

    /**
     * @ORM\Column(type="text")
     */
    protected $userInputAnswer;

    /**
     * @ORM\ManyToOne(targetEntity="GradeTest", cascade={"persist"}, inversedBy="gradeQuestions")
     * @ORM\JoinColumn(name="grade_test_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $gradeTest;

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
     * Set userInputAnswer
     *
     * @param string $userInputAnswer
     *
     * @return GradeQuestion
     */
    public function setUserInputAnswer($userInputAnswer)
    {
        $this->userInputAnswer = $userInputAnswer;

        return $this;
    }

    /**
     * Get userInputAnswer
     *
     * @return string
     */
    public function getUserInputAnswer()
    {
        return $this->userInputAnswer;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return GradeQuestion
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set gradeTest
     *
     * @param \AppBundle\Entity\GradeTest $gradeTest
     *
     * @return GradeQuestion
     */
    public function setGradeTest(\AppBundle\Entity\GradeTest $gradeTest = null)
    {
        $this->gradeTest = $gradeTest;

        return $this;
    }

    /**
     * Get gradeTest
     *
     * @return \AppBundle\Entity\GradeTest
     */
    public function getGradeTest()
    {
        return $this->gradeTest;
    }
}
