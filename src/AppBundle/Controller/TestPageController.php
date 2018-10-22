<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Course;
use AppBundle\Entity\GradeTest;
use AppBundle\Entity\Test;
use AppBundle\Repository\TestRepository;
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
     * @Route("/test/pending-tests", name="test-pending-tests")
     * @Security("has_role('ROLE_USER')")
     */
    public function pendingAction(Request $request)
    {

        $repository = $this->getRepository('AppBundle:GradeTest');

        $user = $this->getUser();

        $gradeTests = $repository->findBy(['teacher' => $user->getId()]);


        return $this->render('testpage/pendingTests.html.twig', ['pendingTests' => $gradeTests]);
    }

    /**
     * @Route("/test/test-statistics", name="test-statistics")
     * @Security("has_role('ROLE_USER')")
     */
    public function statisticsAction()
    {
        /**
         * @var TestRepository $repository
         */
        $repository = $this->getRepository('AppBundle:Test');

        $user = $this->getUser();

        $tests = $repository->findByOwner($user);


        return $this->render('testpage/statisticsTests.html.twig', ['tests' => $tests]);
    }


    /**
     * @Route("/tests/result", name="tests-result")
     * @Security("has_role('ROLE_USER')")
     */
    public function resultsAction()
    {
        $repository = $this->getRepository('AppBundle:TestResult');

        $user = $this->getUser();

        $testsResult = $repository->findBy(['user' => $user->getId()]);


        return $this->render('testpage/results.html.twig', ['testsResult' => $testsResult]);
    }

    /**
     * @Route("/test/view-report/{test}", name="view-report")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewReportAction(Test $test)
    {
        /**
         * @var TestRepository $repository
         */
        $repository = $this->getRepository('AppBundle:TestResult');

        $testResults = $repository->findBy(['test' => $test->getId()]);


        return $this->render('testpage/viewReport.html.twig', ['testResults' => $testResults, 'test' => $test]);
    }

    /**
     * @Route("/test/grade/{gradeTest}", name="test-grade")
     * @Security("has_role('ROLE_USER')")
     */
    public function gradeAction(GradeTest $gradeTest, Request $request)
    {
        return $this->render('testpage/gradeTest.html.twig', ['gradeTest' => $gradeTest, 'gradeQuestions' => $gradeTest->getGradeQuestions()->getValues()]);
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
        return $this->render('testpage/test.html.twig');
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
    public function deleteAction(Test $test, Request $request)
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
        } elseif (count($questions) > 0) {
            $question = $questions[0];
        }

        return $question;
    }

}