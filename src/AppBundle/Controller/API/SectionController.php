<?php

namespace AppBundle\Controller\API;


use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class SectionController.
 *
 * @Rest\NamePrefix("api_")
 * @Rest\RouteResource("section")
 */
class SectionController extends BaseRestController
{
    /**
     * Return section.
     *
     * @Rest\QueryParam(name="_sort")
     * @Rest\QueryParam(name="_limit",  requirements="\d+", nullable=true, strict=true)
     * @Rest\QueryParam(name="_offset", requirements="\d+", nullable=true, strict=true)
     * @Rest\QueryParam(name="course", description="course id")
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        /** @var EntityRepository $repository */
        $repository = $this->getRepository('AppBundle:Section');
        $paramFetcher = $paramFetcher->all();

        return $this->matching($repository, $paramFetcher, null, ['default']);
    }
}