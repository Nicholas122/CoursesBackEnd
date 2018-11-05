<?php

namespace AppBundle\Service;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseNotification;
use AppBundle\Entity\CourseSubscriber;
use AppBundle\Entity\User;
use AppBundle\Repository\LectureRepository;
use AppBundle\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseSubscribeService
{
    private $em;

    private $courseNotification;

    public function __construct(CourseNotificationService $courseNotification, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->courseNotification = $courseNotification;
    }

    public function subscribe(Course $course, User $user)
    {
       if ($this->isSubscribed($course, $user) === false) {
           $courseSubscriber = new CourseSubscriber();
           $courseSubscriber->setCourse($course);
           $courseSubscriber->setUser($user);

           $this->em->persist($courseSubscriber);
           $this->em->flush();

           $this->createNotifications($course, $user);
       }
    }

    public function createNotifications(Course $course, User $user)
    {
        /**
         * @var LectureRepository $lectureRepository
         */
        $lectureRepository = $this->em->getRepository('AppBundle:Lecture');

        /**
         * @var TestRepository $testRepository
         */
        $testRepository = $this->em->getRepository('AppBundle:Test');

        $lectures = $lectureRepository->findByCourse($course);

        $tests = $testRepository->findByCourse($course);

        $notificationsCount = count($lectures) + count($tests);

        for ($i = 0; $i < $notificationsCount; $i++) {
            $courseNotification = new CourseNotification();

            $courseNotification->setUser($user);
            $courseNotification->setCourse($course);
            $courseNotification->setViewed(0);
            $courseNotification->setType('course');

            $this->em->persist($courseNotification);
        }

        $this->em->flush();


    }

    public function unsubscribe(Course $course, User $user)
    {
        $courseSubscriber = $this->em->getRepository('AppBundle:CourseSubscriber')->findOneBy(['user' => $user->getId(), 'course' => $course->getId()]);

        if ($courseSubscriber instanceof CourseSubscriber) {
            $this->em->remove($courseSubscriber);
            $this->em->flush();
        }
    }

    public function isSubscribed(Course $course, User $user)
    {
        $courseSubscriber = $this->em->getRepository('AppBundle:CourseSubscriber')->findOneBy(['user' => $user->getId(), 'course' => $course->getId()]);

        return boolval($courseSubscriber);
    }
}