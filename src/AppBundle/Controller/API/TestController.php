<?php

namespace AppBundle\Controller\API;


use AppBundle\Entity\Test;
use AppBundle\Form\TestForm;
use AppBundle\Service\TestService;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $test = new Test();

        $createTestResponse = $this->handleForm($request, TestForm::class, $test);

        if ($createTestResponse->getStatusCode() === 201) {
            $questions = $request->request->get('questions');
            $testService->createQuestions($questions, $test);
        }

        return $createTestResponse;
    }

    /**
     * Update test.
     */
    public function putAction(Test $test, Request $request)
    {
        /**
         * @var TestService $testService
         */
        $testService = $this->get('app.test.service');
        $createTestResponse = $this->handleForm($request, TestForm::class, $test, [], true);

        if ($createTestResponse->getStatusCode() === 200) {
            $questions = $request->get('questions');
            $testService->updateQuestions($questions, $test);
        }

        return $createTestResponse;
    }

    /**
     * Pass test.
     */
    public function postPassAction(Test $test, Request $request)
    {
        /**
         * @var TestService $testService
         */
        $testService = $this->get('app.test.service');

        $testResult = $testService->passTest($test, $this->getUser(), $request->request->get('answers'));

        return $this->baseSerialize($testResult);

    }

    /**
     * Get test.
     * @Rest\View(serializerGroups={"default"})
     */
    public function getAction(Test $test)
    {
        return $test;
    }
}
