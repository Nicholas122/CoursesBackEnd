<?php

namespace AppBundle\Controller\API;


use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class TestController.
 *
 * @Rest\NamePrefix("api_")
 * @Rest\RouteResource("test", pluralize=false)
 */
class TestController extends BaseRestController
{
    /**
     * Create test.
     */
    public function postAction(Request $request)
    {
       var_dump($request->request->get('test')); die;
    }
}