<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Course;
use AppBundle\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class TestPageController extends BaseController
{
    /**
     * @Route("/test-new/{course}", name="test-new")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Course $course, Request $request)
    {
        return $this->render('testpage/new.html.twig');
    }

    /**
     * @Route("/test-edit/{test}", name="test-edit")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Test $test, Request $request)
    {
        return $this->render('testpage/edit.html.twig');
    }

    /**
     * @Route("/test/{test}", name="test")
     * @Security("has_role('ROLE_USER')")
     */
    public function testAction(Test $test, Request $request)
    {
        return $this->render('testpage/test.html.twig', ['test' => $test]);
    }

    /**
     * @Route("/test/{test}/pass", name="test-pass")
     * @Security("has_role('ROLE_USER')")
     */
    public function passAction(Test $test, Request $request)
    {
        $questions = $this->getQuestionsByTest($test);

        return $this->render('testpage/pass.html.twig', [
            'test' => $test,
            'questions' => $this->getQuestionsByTest($test),
            'question' => $this->getQuestionById($request->get('question'), $questions)]);
    }

    private function getQuestionsByTest(Test $test)
    {
        $repository = $this->getRepository('AppBundle:Question');

        $questions = $repository->findBy(['test' => $test->getId()]);

        return $questions;
    }

    private function getQuestionById($questionId, $questions)
    {
        $question = null;

        $repository = $this->getRepository('AppBundle:Question');

        if ($questionId) {
            $question = $repository->findOneById($questionId);
        } elseif(count($questions) > 0) {
            $question = $questions[0];
        }

        return $question;
    }

}