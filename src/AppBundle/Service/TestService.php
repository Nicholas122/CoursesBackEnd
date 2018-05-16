<?php

namespace AppBundle\Service;


use AppBundle\Entity\Answer;
use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
use AppBundle\Entity\ReadingQuestion;
use AppBundle\Entity\ReadingSubQuestion;
use AppBundle\Entity\Test;
use AppBundle\Entity\User;
use AppBundle\Entity\UserInputQuestion;
use Doctrine\ORM\EntityManagerInterface;

class TestService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createQuestions($questionsData, Test $test)
    {
        foreach ($questionsData as $questionData) {
            switch ($questionData['type']) {
                case 'USER_INPUT':
                    $question = new UserInputQuestion();
                    $question->setText($questionData['text']);
                    $question->setWeight($questionData['weight']);
                    $question->setQuestionType('USER_INPUT');
                    $question->setTest($test);
                    break;
                case 'MULTIPLE_CHOICE':
                    $question = new MultipleChoiceQuestion();
                    $question->setText($questionData['text']);
                    $question->setWeight($questionData['weight']);
                    $question->setTest($test);
                    $question->setQuestionType('MULTIPLE_CHOICE');
                    $this->createAnswers($questionData['answers'], $question);
                    break;
                case 'READING_TEXT':
                    $question = new ReadingQuestion();
                    $question->setText($questionData['text']);
                    $question->setReadingText($questionData['readingText']);
                    $question->setWeight($questionData['weight']);
                    $question->setQuestionType('READING_TEXT');
                    $question->setTest($test);
                    $this->createSubQuestions($questionData['subQuestions'], $question);

                    break;
            }

            $this->em->persist($question);
        }

        $this->em->flush();
    }

    private function createAnswers($answersData, Question $question)
    {
        foreach ($answersData as $answerData) {
            $answer = new Answer();
            $answer->setQuestion($question);
            $answer->setText($answerData['text']);
            $answer->setIsCorrect(boolval($answerData['correct']));

            $this->em->persist($answer);
        }
    }

    private function createSubQuestions($subQuestions, ReadingQuestion $question)
    {
        foreach ($subQuestions as $item) {
            $subQuestion = new ReadingSubQuestion();
            $subQuestion->setParent($question);
            $subQuestion->setText($item['questionText']);
            $subQuestion->setWeight(1);
            $subQuestion->setQuestionType('READING_SUB_QUESTION');
            $this->createAnswers($item['answers'], $subQuestion);

            $this->em->persist($subQuestion);
        }
    }


}