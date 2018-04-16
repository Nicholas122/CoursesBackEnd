<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Lecture;
use AppBundle\Form\LectureForm;
use AppBundle\Repository\LectureRepository;
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
     * @Route("/lecture/{lecture}", name="lecture")
     * @Security("has_role('ROLE_USER')")
     */
    public function lectureAction(Lecture $lecture, Request $request)
    {
        /**
         * @var LectureRepository $repository
         */
        $repository = $this->getRepository('AppBundle:Lecture');

        $sections = $this->getRepository('AppBundle:Section')->findBy(['course' => $lecture->getSection()->getCourse()]);

        $nextLecture = $repository->getNextLecture($lecture);
        $previousLecture = $repository->getPreviousLecture($lecture);


        return $this->render('lecturepage/lecture.html.twig', [
            'lecture' => $lecture, 'sections' => $sections,
            'nextLecture' => $nextLecture, 'previousLecture' => $previousLecture
        ]);
    }
}
