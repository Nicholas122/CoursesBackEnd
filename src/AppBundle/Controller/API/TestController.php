<?php

namespace AppBundle\Controller\API;


use AppBundle\Entity\Test;
use AppBundle\Form\TestForm;
use AppBundle\Service\TestService;
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
        /**
         * @var TestService $testService
         */
        $testService = $this->get('app.test.service');

        $createTestResponse = $this->handleForm($request, TestForm::class, new Test());

        if ($createTestResponse->getStatusCode() === 201) {
            $questions = $request->get('questions');
            $testService->createQuestions($questions);
        }

        return $createTestResponse;
    }
}