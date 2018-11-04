<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Course;
use AppBundle\Entity\Section;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GetCourseNotificationCount extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getCourseNotificationCount', array($this, 'getCourseNotificationCount')),
        );
    }

    public function getCourseNotificationCount(Course $course, User $user)
    {
        $repository = $this->entityManager->getRepository('AppBundle:CourseNotification');

        $response = count($repository->findBy(['course' => $course->getId(), 'user' => $user->getId(), 'viewed' => 0]));

        return $response;
    }

}