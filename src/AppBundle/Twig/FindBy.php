<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Question;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;

class FindBy extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('findBy', array($this, 'findBy')),
        );
    }

    public function findBy($entity, $criteria)
    {
        $repository = $this->entityManager->getRepository($entity);

        $response = $repository->findBy($criteria);

        return $response;
    }

}