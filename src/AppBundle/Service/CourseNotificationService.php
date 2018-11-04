<?php


namespace AppBundle\Service;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseNotification;
use AppBundle\Entity\User;
use AppBundle\Repository\CourseNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseNotificationService
{
    public function createNotification(Course $course, $type, User $user, $em)
    {
        $courseNotification = new CourseNotification();

        $courseNotification->setCourse($course);
        $courseNotification->setType($type);
        $courseNotification->setUser($user);
        $courseNotification->setViewed(0);

        $em->persist($courseNotification);
        $em->flush();
    }

    public function viewAllNotifications(Course $course, User $user, $em)
    {
        /**
         * @var CourseNotificationRepository $repository
         */
        $repository = $em->getRepository('AppBundle:CourseNotification');

        $repository->viewAllNotifications($course, $user);
    }
}