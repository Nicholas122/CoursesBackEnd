<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Section;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GetCheckedTestResultCount extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getCheckedTestResultCount', array($this, 'getCheckedTestResultCount')),
        );
    }

    public function getCheckedTestResultCount(User $user)
    {
        $repository = $this->entityManager->getRepository('AppBundle:TestResult');

        $response = count($repository->findBy(['user' => $user->getId(), 'checked' => 1, 'viewed' => null]));

        return $response;
    }

}