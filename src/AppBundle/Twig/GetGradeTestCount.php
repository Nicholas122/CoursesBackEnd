<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Section;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GetGradeTestCount extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getGradeTestCount', array($this, 'getGradeTestCount')),
        );
    }

    public function getGradeTestCount(User $user)
    {
        $repository = $this->entityManager->getRepository('AppBundle:GradeTest');

        $response = count($repository->findBy(['teacher' => $user->getId()]));

        return $response;
    }

}