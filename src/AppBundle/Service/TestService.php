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


    public function updateQuestions($questionsData, Test $test)
    {
        $repository = $this->em->getRepository('AppBundle:Question');
        $allQuestions = $repository->findBy(['test' => $test->getId()]);

        if (count($allQuestions) > count($questionsData)) {
            foreach ($allQuestions as $question) {
                $exist = false;
                foreach ($questionsData as $questionData) {
                    $exist = $question->getId() === $questionData['id'];
                }

                if ($exist === false) {
                    $this->em->remove($question);
                }
            }

            $this->em->flush();
        }

        foreach ($questionsData as $questionData) {
            $question = $repository->findOneById($questionData['id']);

            if ($question instanceof Question) {
                switch ($question->getQuestionType()) {
                    case 'USER_INPUT':
                        $question->setText($questionData['text']);
                        $question->setWeight($questionData['weight']);
                        $question->setQuestionType('USER_INPUT');
                        $question->setTest($test);
                        break;
                    case 'MULTIPLE_CHOICE':
                        $question->setText($questionData['text']);
                        $question->setWeight($questionData['weight']);
                        $question->setTest($test);
                        $question->setQuestionType('MULTIPLE_CHOICE');
                        $this->updateAnswers($questionData['answers'], $question);
                        break;
                    case 'READING_TEXT':
                        $question->setText($questionData['text']);
                        $question->setReadingText($questionData['readingText']);
                        $question->setWeight($questionData['weight']);
                        $question->setQuestionType('READING_TEXT');
                        $question->setTest($test);
                        $this->updateSubQuestions($questionData['subQuestions'], $question);

                        break;
                }

                $this->em->persist($question);
            } else {
                $this->createQuestions([$questionData], $test);
            }
        }

        $this->em->flush();
    }

    private function updateAnswers($answersData, Question $question)
    {
        $repository = $this->em->getRepository('AppBundle:Answer');

        foreach ($answersData as $answerData) {
            $answer = $repository->findOneById($answerData['id']);
            if ($answer instanceof Answer) {
                $answer->setQuestion($question);
                $answer->setText($answerData['text']);
                $answer->setIsCorrect(boolval($answerData['correct']));
                $this->em->persist($answer);
            } else {
                $this->createAnswers([$answerData], $question);
            }
        }
    }

    private function updateSubQuestions($subQuestions, ReadingQuestion $question)
    {
        $repository = $this->em->getRepository('AppBundle:ReadingSubQuestion');

        foreach ($subQuestions as $item) {
            $subQuestion = $repository->findOneById($item['id']);

            if ($subQuestion instanceof ReadingSubQuestion) {

                $subQuestion->setParent($question);
                $subQuestion->setText($item['questionText']);
                $subQuestion->setWeight(1);
                $subQuestion->setQuestionType('READING_SUB_QUESTION');
                $this->createAnswers($item['answers'], $subQuestion);

                $this->em->persist($subQuestion);
            } else {
                $this->createSubQuestions([$item], $question);
            }
        }
    }


}