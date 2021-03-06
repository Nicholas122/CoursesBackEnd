<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * ReadingQuestion.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ReadingQuestion extends Question
{
    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    protected $readingText;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\OneToMany(targetEntity="ReadingSubQuestion", mappedBy="parent")
     */
    protected $subQuestions;



    /**
     * Set readingText
     *
     * @param string $readingText
     *
     * @return ReadingQuestion
     */
    public function setReadingText($readingText)
    {
        $this->readingText = $readingText;

        return $this;
    }

    /**
     * Get readingText
     *
     * @return string
     */
    public function getReadingText()
    {
        return $this->readingText;
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
     * Set text
     *
     * @param string $text
     *
     * @return ReadingQuestion
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return ReadingQuestion
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return ReadingQuestion
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return ReadingQuestion
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
     * Set questionType
     *
     * @param string $questionType
     *
     * @return ReadingQuestion
     */
    public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;

        return $this;
    }

    /**
     * Get questionType
     *
     * @return string
     */
    public function getQuestionType()
    {
        return $this->questionType;
    }

    /**
     * Add subQuestions
     *
     * @param \AppBundle\Entity\ReadingSubQuestion $subQuestions
     *
     * @return ReadingQuestion
     */
    public function addSubQuestions(\AppBundle\Entity\ReadingSubQuestion $subQuestions)
    {
        $this->subQuestions[] = $subQuestions;

        return $this;
    }

    /**
     * Remove subQuestions
     *
     * @param \AppBundle\Entity\ReadingSubQuestion $subQuestions
     */
    public function removeSubQuestions(\AppBundle\Entity\ReadingSubQuestion $subQuestions)
    {
        $this->subQuestions->removeElement($subQuestions);
    }

    /**
     * Get subQuestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubQuestions()
    {
        return $this->subQuestions;
    }

    /**
     * Add subQuestion
     *
     * @param \AppBundle\Entity\ReadingSubQuestion $subQuestion
     *
     * @return ReadingQuestion
     */
    public function addSubQuestion(\AppBundle\Entity\ReadingSubQuestion $subQuestion)
    {
        $this->subQuestions[] = $subQuestion;

        return $this;
    }

    /**
     * Remove subQuestion
     *
     * @param \AppBundle\Entity\ReadingSubQuestion $subQuestion
     */
    public function removeSubQuestion(\AppBundle\Entity\ReadingSubQuestion $subQuestion)
    {
        $this->subQuestions->removeElement($subQuestion);
    }
}
