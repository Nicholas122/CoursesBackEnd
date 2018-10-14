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
class QuestionResult
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
     * @ORM\ManyToOne(targetEntity="TestResult", inversedBy="questionResults")
     * @ORM\JoinColumn(name="test_result_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $testResult;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="ReadingSubQuestion")
     * @ORM\JoinColumn(name="sub_question_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $subQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="Answer")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $answer;


    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="text", nullable=true)
     */
    protected $userInputAnswer;


    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $isCorrect;

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
     * Set testResult
     *
     * @param \AppBundle\Entity\TestResult $testResult
     *
     * @return QuestionResult
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

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return QuestionResult
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
     * Set answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return QuestionResult
     */
    public function setAnswer(\AppBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \AppBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set userInputAnswer
     *
     * @param string $userInputAnswer
     *
     * @return QuestionResult
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
     * Set subQuestion
     *
     * @param \AppBundle\Entity\ReadingSubQuestion $subQuestion
     *
     * @return QuestionResult
     */
    public function setSubQuestion(\AppBundle\Entity\ReadingSubQuestion $subQuestion = null)
    {
        $this->subQuestion = $subQuestion;

        return $this;
    }

    /**
     * Get subQuestion
     *
     * @return \AppBundle\Entity\ReadingSubQuestion
     */
    public function getSubQuestion()
    {
        return $this->subQuestion;
    }

    /**
     * Set isCorrect
     *
     * @param integer $isCorrect
     *
     * @return QuestionResult
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return integer
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }
}
