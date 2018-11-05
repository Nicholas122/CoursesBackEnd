<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\CourseSubscriber;
use AppBundle\Entity\Lecture;
use AppBundle\Entity\Test;
use AppBundle\Entity\User;
use AppBundle\Service\CourseNotificationService;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Doctrine\ORM\Mapping as ORM;

class TestEntityListener
{

    /**
     * @var CourseNotificationService $courseNotificationService
     */
    private $courseNotificationService;

    /**
     * TestEntityListener constructor.
     *
     * @param CourseNotificationService $courseNotificationService
     */
    public function __construct(CourseNotificationService $courseNotificationService)
    {
        $this->courseNotificationService = $courseNotificationService;
    }

    /**
     *
     * @param Test      $entity
     * @param LifecycleEventArgs $args
     *
     * @ORM\PostPersist
     */
    public function createCourseNotification(Test $test, LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();

        $course = $test->getSection()->getCourse();

        $courseSubscriberRepository = $em->getRepository('AppBundle:CourseSubscriber');

        $courseSubscribers = $courseSubscriberRepository->findBy(['course' => $course->getId()]);

        /**
         * @var CourseSubscriber $courseSubscriber
         */
        foreach ($courseSubscribers as $courseSubscriber) {
            $this->courseNotificationService->createNotification($course, 'test', $courseSubscriber->getUser(), $em);
        }
    }

}
