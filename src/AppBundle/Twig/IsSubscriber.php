<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Course;
use AppBundle\Entity\User;
use AppBundle\Service\CourseSubscribeService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class IsSubscriber extends \Twig_Extension
{

    /**
     * @var CourseSubscribeService $courseSubscribeService
     */
    private $courseSubscribeService;

    public function __construct(ContainerInterface $container)
    {
        $this->courseSubscribeService = $container->get('app.course_subscriber.service');
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('isSubscriber', array($this, 'isSubscriber')),
        );
    }

    public function isSubscriber(Course $course, User $user)
    {
        return $this->courseSubscribeService->isSubscribed($course, $user);
    }

}