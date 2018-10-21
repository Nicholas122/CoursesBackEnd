<?php

namespace AppBundle\Service;


use AppBundle\Entity\Answer;
use AppBundle\Entity\GradeQuestion;
use AppBundle\Entity\GradeTest;
use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
use AppBundle\Entity\QuestionResult;
use AppBundle\Entity\ReadingQuestion;
use AppBundle\Entity\ReadingSubQuestion;
use AppBundle\Entity\Test;
use AppBundle\Entity\TestResult;
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

    public function passTest(Test $test, User $user, $answers)
    {
        $result = 0;
        $sumWeight = 0;

        $questionRepository = $this->em->getRepository('AppBundle:Question');
        $answerRepository = $this->em->getRepository('AppBundle:Answer');
        $readingSubQuestionRepository = $this->em->getRepository('AppBundle:ReadingSubQuestion');

        $testResult = new TestResult();
        $testResult->setTest($test);
        $testResult->setUser($user);
        $testResult->setResult(0);
        $testResult->setOneWeightInPercent(0);

        $this->em->persist($testResult);
        $this->em->flush();

        $gradeTest = new GradeTest();
        $gradeTest->setTest($test);
        $gradeTest->setStudent($user);
        $gradeTest->setTeacher($test->getSection()->getCourse()->getUser());

        foreach ($answers as $item) {
            $question = $questionRepository->findOneById($item['questionId']);
            if ($question instanceof Question) {
                $sumWeight += $question->getWeight();

                $questionResult = new QuestionResult();

                $questionResult->setQuestion($question);

                if ($question->getQuestionType() === 'USER_INPUT') {
                    $questionResult->setUserInputAnswer($item['value']);

                    $this->em->persist($gradeTest);

                    $gradeQuestion = new GradeQuestion();
                    $gradeQuestion->setQuestion($question);
                    $gradeQuestion->setUserInputAnswer($item['value']);
                    $gradeQuestion->setGradeTest($gradeTest);

                    $this->em->persist($gradeQuestion);

                } elseif ($question->getQuestionType() === 'READING_TEXT') {
                    $ids = explode('|', $item['value']);
                    $answer = $answerRepository->findOneById($ids[0]);
                    $subQuestion = $readingSubQuestionRepository->findOneById($ids[1]);

                    if ($answer instanceof Answer && $subQuestion instanceof ReadingSubQuestion) {
                        $questionResult->setAnswer($answer);
                        $questionResult->setIsCorrect($answer->getIsCorrect());
                        $questionResult->setSubQuestion($subQuestion);
                    }

                } else {
                    $answer = $answerRepository->findOneById($item['value']);

                    if ($answer instanceof Answer) {
                        $questionResult->setAnswer($answer);
                        $questionResult->setIsCorrect($answer->getIsCorrect());
                    }
                }

                $this->em->persist($questionResult);
            }
        }

        $oneWeightInPercent = 100 / $sumWeight;

        $testResult->setOneWeightInPercent($oneWeightInPercent);

        foreach ($answers as $item) {
            $question = $questionRepository->findOneById($item['questionId']);
            if ($question instanceof Question) {


                if ($question->getQuestionType() === 'READING_TEXT') {
                    $ids = explode('|', $item['value']);
                    $answer = $answerRepository->findOneById($ids[0]);
                    $subQuestion = $readingSubQuestionRepository->findOneById($ids[1]);

                    if ($answer instanceof Answer && $subQuestion instanceof ReadingSubQuestion && $answer->getIsCorrect()) {
                        $result += $subQuestion->getWeight() * $oneWeightInPercent;
                    }

                } elseif ($question->getQuestionType() === 'MULTIPLE_CHOICE') {
                    $answer = $answerRepository->findOneById($item['value']);

                    if ($answer instanceof Answer && $answer->getIsCorrect()) {
                        $result += $question->getWeight() * $oneWeightInPercent;
                    }
                }

            }
        }

        $testResult->setResult(round($result));

        $this->em->flush();

        return $testResult;
    }

    public function gradeQuestion(GradeQuestion $gradeQuestion, $result)
    {
        $gradeTest = $gradeQuestion->getGradeTest();

        $testResult = $gradeQuestion->getGradeTest()->getTestResult();
        $result = $testResult->getResult();

        switch ($result) {
            case 100:
                $result += $testResult->getOneWeightInPercent() * $gradeQuestion->getQuestion()->getWeight();
                break;
            case 50;
                $result += ($testResult->getOneWeightInPercent() * $gradeQuestion->getQuestion()->getWeight()) / 2;
                break;
        }

        $testResult->setResult($result);

        $this->em->persist($testResult);
        $this->em->remove($gradeTest);

        $this->em->flush();

    }


}