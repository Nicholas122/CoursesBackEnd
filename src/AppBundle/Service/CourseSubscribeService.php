<?php

namespace AppBundle\Service;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseSubscriber;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CourseSubscribeService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function subscribe(Course $course, User $user)
    {
       if ($this->isSubscribed($course, $user) === false) {
           $courseSubscriber = new CourseSubscriber();
           $courseSubscriber->setCourse($course);
           $courseSubscriber->setUser($user);

           $this->em->persist($courseSubscriber);
           $this->em->flush();
       }
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