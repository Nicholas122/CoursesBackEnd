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
     * @Route("/test/new/{course}", name="test-new")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Course $course, Request $request)
    {
        $sections = $this->getRepository('AppBundle:Section')->findBy(['course' => $course->getId()]);

        if ($request->getMethod() === 'POST') {
            //var_dump($request->request->all()); die;
        }

        return $this->render('testpage/new.html.twig', ['sections' => $sections, 'course' => $course]);
    }

    /**
     * @Route("/test/{test}", name="test")
     * @Security("has_role('ROLE_USER')")
     */
    public function testAction(Test $test, Request $request)
    {
        return $this->render('testpage/test.html.twig', ['test' => $test]);
    }

}