<?php

namespace AppBundle\Service;


use AppBundle\Entity\Answer;
use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
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
                case 'MULTIPLY_CHOISE':
                    $question = new MultipleChoiceQuestion();
                    $question->setText($questionData['text']);
                    $question->setWeight($questionData['weight']);
                    $question->setTest($test);
                    $question->setQuestionType('MULTIPLY_CHOISE');
                    $this->createAnswers($questionData['answers'], $question);
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


}