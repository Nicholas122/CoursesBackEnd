<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Lecture;
use AppBundle\Form\LectureForm;
use AppBundle\Repository\LectureRepository;
use AppBundle\Repository\TestRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LecturePageController extends BaseController
{
    /**
     * @Route("/lecture/new/{course}", name="lecture-new")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Course $course, Request $request)
    {
        $lecture = new Lecture();
        $form = $this->createForm(LectureForm::class, $lecture, ['course' => $course]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($lecture);
            $em->flush();

            return $this->redirectToRoute('course', ['course' => $course->getId()]);
        }


        return $this->render('lecturepage/new.html.twig', ['form' => $form->createView(), 'course' => $course]);
    }

    /**
     * @Route("/lecture-edit/{lecture}", name="lecture-edit")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Lecture $lecture, Request $request)
    {
        $form = $this->createForm(LectureForm::class, $lecture, ['course' => $lecture->getSection()->getCourse()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($lecture);
            $em->flush();

            return $this->redirectToRoute('course', ['course' => $lecture->getSection()->getCourse()->getId()]);
        }


        return $this->render('lecturepage/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/lecture/{lecture}", name="lecture")
     * @Security("has_role('ROLE_USER')")
     */
    public function lectureAction(Lecture $lecture, Request $request)
    {
        /**
         * @var LectureRepository $repository
         */
        $repository = $this->getRepository('AppBundle:Lecture');

        /**
         * @var TestRepository $repository
         */
        $testRepository = $this->getRepository('AppBundle:Test');

        $sections = $this->getRepository('AppBundle:Section')->findBy(['course' => $lecture->getSection()->getCourse()]);

        $nextLecture = $repository->getNextLecture($lecture);
        $previousLecture = $repository->getPreviousLecture($lecture);

        $test = $testRepository->findBy(['section' => $lecture->getSection()->getId()], ['id' => 'desc'], 1);

        return $this->render('lecturepage/lecture.html.twig', [
            'lecture' => $lecture, 'sections' => $sections, 'test' => @$test[0],
            'nextLecture' => $nextLecture, 'previousLecture' => $previousLecture
        ]);
    }

    /**
     * @Route("/lecture-delete/{lecture}", name="lecture-delete")
     * @Security("is_granted('ABILITY_LECTURE_DELETE', lecture)")
     */
    public function deleteAction(Lecture $lecture,Request $request)
    {
        $course = $lecture->getSection()->getCourse();

        $em = $this->getDoctrine()->getManager();

        $em->remove($lecture);
        $em->flush();

        return $this->redirectToRoute('course', ['course' => $course->getId()]);
    }
}
