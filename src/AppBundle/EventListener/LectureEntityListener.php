<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\CourseSubscriber;
use AppBundle\Entity\Lecture;
use AppBundle\Entity\User;
use AppBundle\Service\CourseNotificationService;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Doctrine\ORM\Mapping as ORM;

class LectureEntityListener
{

    /**
     * @var CourseNotificationService $courseNotificationService
     */
    private $courseNotificationService;

    /**
     * LectureEntityListener constructor.
     *
     * @param CourseNotificationService $courseNotificationService
     */
    public function __construct(CourseNotificationService $courseNotificationService)
    {
        $this->courseNotificationService = $courseNotificationService;
    }

    /**
     *
     * @param Lecture      $entity
     * @param LifecycleEventArgs $args
     *
     * @ORM\PostPersist
     */
    public function createCourseNotification(Lecture $lecture, LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();

        $course = $lecture->getSection()->getCourse();

        $courseSubscriberRepository = $em->getRepository('AppBundle:CourseSubscriber');

        $courseSubscribers = $courseSubscriberRepository->findBy(['course' => $course->getId()]);

        /**
         * @var CourseSubscriber $courseSubscriber
         */
        foreach ($courseSubscribers as $courseSubscriber) {
            $this->courseNotificationService->createNotification($course, 'lecture', $courseSubscriber->getUser(), $em);
        }
    }

}
