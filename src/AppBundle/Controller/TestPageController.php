<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Course;
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

        return $this->render('testpage/new.html.twig', ['sections' => $sections, 'course' => $course]);
    }

}