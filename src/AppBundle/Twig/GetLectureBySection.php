<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;

class GetLectureBySection extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('lectures', array($this, 'lectures')),
        );
    }

    public function lectures(Section $section)
    {
        $repository = $this->entityManager->getRepository('AppBundle:Lecture');

        $response = $repository->findBy(['section' => $section->getId()]);

        return $response;
    }

}