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

    /**
     * @Route("/test-delete/{test}", name="test-delete")
     * @Security("is_granted('ABILITY_TEST_DELETE', test)")
     */
    public function deleteAction(Test $test,Request $request)
    {
        $course = $test->getSection()->getCourse();

        $em = $this->getDoctrine()->getManager();

        $em->remove($test);
        $em->flush();

        return $this->redirectToRoute('course', ['course' => $course->getId()]);
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