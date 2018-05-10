<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Question;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;

class GetAnswersByQuestions extends \Twig_Extension
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('answers', array($this, 'answers')),
        );
    }

    public function answers(Question $question)
    {
        $repository = $this->entityManager->getRepository('AppBundle:Answer');

        $response = $repository->findBy(['question' => $question->getId()]);

        return $response;
    }

}