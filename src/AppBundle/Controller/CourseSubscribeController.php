<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseSubscriber;
use AppBundle\Form\CourseForm;
use AppBundle\Repository\CourseRepository;
use AppBundle\Service\CourseSubscribeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CourseSubscribeController extends BaseController
{
    /**
     * @Route("/subscribe/{course}", name="course-subscribe")
     *  @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Course $course)
    {
        $this->getCourseSubscribeService->subscribe($course, $this->getUser());

        return $this->redirectToRoute('course', ['course' => $course->getId()]);
    }


    /**
     * @Route("/unsubscribe/{course}", name="course-unsubscribe")
     * @Security("has_role('ROLE_USER')")
     */
    public function unsubscribeAction(Course $course)
    {
        $this->getCourseSubscribeService->unsubscribe($course, $this->getUser());

        return $this->redirectToRoute('courses');
    }

    private function getCourseSubscribeService()
    {
        /**
         * @var CourseSubscribeService $courseSubscriberService
         */
        $courseSubscriberService = $this->get('app.course_subscriber.service');

        return $courseSubscriberService;
    }
}
