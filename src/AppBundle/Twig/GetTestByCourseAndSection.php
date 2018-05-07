<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;

class GetTestByCourseAndSection extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tests', array($this, 'tests')),
        );
    }

    public function tests(Section $section)
    {
        $repository = $this->entityManager->getRepository('AppBundle:Test');

        $response = $repository->findBy(['section' => $section->getId()]);

        return $response;
    }

}