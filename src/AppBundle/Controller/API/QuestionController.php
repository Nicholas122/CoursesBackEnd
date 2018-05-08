<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class QuestionController.
 *
 * @Rest\NamePrefix("api_")
 * @Rest\RouteResource("Question")
 */
class QuestionController extends BaseRestController
{

    /**
     * Return question by id.
     *
     * @Rest\View(serializerGroups={"default"})
     */
    public function getAction(Question $question)
    {
        return $question;
    }

    /**
     * Return question.
     *
     * @Rest\QueryParam(name="_sort")
     * @Rest\QueryParam(name="_limit",  requirements="\d+", nullable=true, strict=true)
     * @Rest\QueryParam(name="_offset", requirements="\d+", nullable=true, strict=true)
     * @Rest\QueryParam(name="test", description="Test id")
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        /** @var EntityRepository $repository */
        $repository = $this->getRepository('AppBundle:Question');
        $paramFetcher = $paramFetcher->all();

        return $this->matching($repository, $paramFetcher, null, ['default']);
    }
}
