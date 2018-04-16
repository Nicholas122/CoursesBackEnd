<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Section;
use AppBundle\Form\SectionForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SectionPageController extends BaseController
{
    /**
     * @Route("/section/new/{course}", name="section-new")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Course $course, Request $request)
    {
        $section = new Section();
        $form = $this->createForm(SectionForm::class, $section);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $section->setCourse($course);
            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('course', ['course' => $course->getId()]);
        }


        return $this->render('sectionpage/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/section-edit/{section}", name="section-edit")
     * @Security("is_granted('ABILITY_SECTION_UPDATE', section)")
     */
    public function editAction(Section $section, Request $request)
    {
        $form = $this->createForm(SectionForm::class, $section);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('course', ['course' => $section->getCourse()->getId()]);
        }


        return $this->render('sectionpage/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/section-delete/{section}", name="section-edit")
     * @Security("is_granted('ABILITY_SECTION_DELETE', section)")
     */
    public function deleteAction(Section $section, Request $request)
    {
        $courseId = $section->getCourse()->getId();

        $em = $this->getDoctrine()->getManager();

        $em->remove($section);
        $em->flush();

        return $this->redirectToRoute('course', ['course' => $courseId]);
    }
}
