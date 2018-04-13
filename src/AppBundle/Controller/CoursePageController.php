<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Form\CourseForm;
use AppBundle\Repository\CourseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CoursePageController extends BaseController
{
    /**
     * @Route("/courses", name="courses")
     */
    public function indexAction(Request $request)
    {
        /**
         * @var CourseRepository $repository
         */
        $repository = $this->getRepository('AppBundle:Course');

        $criteria = ['status' => 'publish'];

        if ($request->get('category')) {
            $criteria['category'] = $request->get('category');
        }

        if ($request->get('language')) {
            $criteria['language'] = $request->get('language');
        }

        if ($request->get('author')) {
            $criteria['user'] = $request->get('author');
        }

        $courses = $repository->findBy($criteria);
        $filtersData = $repository->getFiltersData();

        return $this->render('coursepage/index.html.twig', [
            'courses' => $courses, 'filtersData' => $filtersData,
            'criteria' => $criteria]);
    }

    /**
     * @Route("/courses/my", name="courses-my")
     * @Security("has_role('ROLE_USER')")
     */
    public function myAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Course');

        $courses = $repository->findBy(['user' => $this->getUser()->getId()]);

        $subscribedCourses = $repository->findSubscribedCourses($this->getUser()->getId());

        return $this->render('coursepage/my.html.twig', ['courses' => $courses, 'subscribedCourses' => $subscribedCourses]);
    }


    /**
     * @Route("/course/{course}", name="course")
     * @Security("has_role('ROLE_USER')")
     */
    public function courseAction(Course $course)
    {
        return $this->render('coursepage/course.html.twig', ['course' => $course]);
    }


    /**
     * @Route("/courses/new", name="courses-new")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseForm::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('courses-my');
        }


        return $this->render('coursepage/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/courses-edit/{course}", name="courses-new")
     * @Security("is_granted('ABILITY_COURSE_UPDATE', course)")
     */
    public function editAction(Course $course,Request $request)
    {
        $form = $this->createForm(CourseForm::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('courses-my');
        }


        return $this->render('coursepage/new.html.twig', ['form' => $form->createView()]);
    }
}
