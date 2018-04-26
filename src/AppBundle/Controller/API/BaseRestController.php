<?php

namespace AppBundle\Controller\API;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;

abstract class BaseRestController extends FOSRestController
{
    protected $entityMapping = [
        'phones' => 'ClientPhone',
        'emails' => 'ClientEmail',
    ];

    public function translate($code, $domain)
    {
        /**
         * @var Translator $translator
         */
        $translator = $this->get('translator');

        $translate = $translator->trans($code, [], $domain);

        return $translate;
    }

    public function responseMessage($status, array $data, $statusCode = 200)
    {
        $response = [
            'status' => $status,
            'data' => $data,
        ];

        $response = $this->baseSerialize($response, [], $statusCode);

        return $response;
    }

    public function responseErrorMessage($errorType, array $errors, $statusCode = 422)
    {
        $response = [
            'error_type' => $errorType,
            'errors' => $errors,
        ];

        $response = $this->baseSerialize($response, [], $statusCode);

        return $response;
    }


    /**
     * @param string $className
     *
     * @return EntityRepository
     */
    public function getRepository($className)
    {
        return $this->getDoctrine()->getManager()->getRepository($className);
    }

    /**
     * @param EntityRepository  $repository
     * @param array             $fields
     * @param callable|\Closure $callback
     *
     * @return Response
     */
    public function matching(EntityRepository $repository, array $fields = array(), \Closure $callback = null, $groups = [], $matchingOptions = [])
    {
        $response = new Response();
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata($repository->getClassName());
        $fields = array_filter($fields, function ($value) {
            return $value == (string) 0 ? true : !empty($value);
        });

        $sort = null;
        $offset = null;
        $limit = null;

        if (isset($fields['_sort'])) {
            $sort = $fields['_sort'];
            unset($fields['_sort']);
        }

        if (isset($fields['_offset'])) {
            $offset = $fields['_offset'];
            unset($fields['_offset']);
        } else {
            $offset = 0;
        }

        if (isset($fields['_limit'])) {
            $limit = $fields['_limit'];
            unset($fields['_limit']);
        }

        $queryBuilder = $repository->createQueryBuilder('entity');
        $expr = $queryBuilder->expr();
        foreach ($fields as $field => $value) {
            if (is_array($value)) {
                if ($classMetadata->isCollectionValuedAssociation($field)) {
                    $queryBuilder->leftJoin(
                        'AppBundle:'.(array_key_exists($field, $this->entityMapping) ? $this->entityMapping[$field] : ucfirst($field)),
                        $field, 'WITH',
                        $field.'.'.strtolower(substr($repository->getClassName(), strrpos($repository->getClassName(), '\\') + 1)).' = entity.id'
                    );
                    $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata('AppBundle\\Entity\\'.(array_key_exists($field, $this->entityMapping) ? $this->entityMapping[$field] : ucfirst($field)));
                    foreach ($value as $f => $v) {
                        $queryBuilder = $this->filter($queryBuilder, $expr, $classMetadata, $field.'.'.$f, $v);
                    }
                } elseif ($classMetadata->hasAssociation($field)) {
                    $queryBuilder->innerJoin('entity.'.$field, $field);
                    foreach ($value as $f => $v) {
                        $column = $field.'.'.$f;
                        $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata('AppBundle\\Entity\\'.ucfirst($field));
                        $queryBuilder = $this->filter($queryBuilder, $expr, $classMetadata, $column, $v);
                    }
                } else {
                    $queryBuilder = $this->multipleFilter($queryBuilder, $expr, $classMetadata, $field, $value);
                }
            } else {
                $classMetadata = $this->getDoctrine()->getManager()->getClassMetadata($repository->getClassName());
                $queryBuilder = $this->filter($queryBuilder, $expr, $classMetadata, 'entity.'.$field, $value);
            }
        }

        if ($callback) {
            $callback($queryBuilder);
        }
        $count = clone $queryBuilder;
        $count = $count->select('entity.id')->distinct('entity.id')->getQuery()->getResult();
        $count = count($count);
        if ($offset < $count) {
            $end = isset($limit) ? $offset + $limit : $count;
            $end = $end > $count ? $count : $end;
            $response->headers->set('Content-Range', "items {$offset}-{$end}/{$count}");
        }
        if ($count == 0) {
            $response->headers->set('Content-Range', 'items 0-0/0');
        }

        $queryBuilder->addGroupBy('entity.id');
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);

        if (isset($sort)) {
            if (count($sort) > 1){
                foreach ($sort as $key => $value){
                    if ($classMetadata->hasField($key)) {
                        $queryBuilder->addOrderBy('entity.' . $key, $value);
                    }
                }
            }
            else{
                $field = key($sort);
                if ($classMetadata->hasField($field)) {
                    $queryBuilder->orderBy('entity.'.key($sort), array_shift($sort));
                } elseif (strpos($field, '[') != false) {
                    $entity = explode('[', $field);
                    if ($classMetadata->hasAssociation($entity[0])) {
                        $subMetadata = $this->getDoctrine()->getManager()->getClassMetadata('AppBundle\\Entity\\'.ucfirst($entity[0]));
                        if ($subMetadata->hasField($entity[1])) {
                            if (!strpos($queryBuilder->getDQL(), 'entity.'.$entity[0])) {
                                $queryBuilder->innerJoin('entity.'.$entity[0], $entity[0]);
                            }
                            $queryBuilder->orderBy($entity[0].'.'.$entity[1], array_shift($sort));
                        }
                    }
                }
            }
        }
        $query = $queryBuilder->getQuery();

        if (isset($matchingOptions['returnQuery']) && $matchingOptions['returnQuery']) {

            return $query;
        }

        $result = $query->getResult();

        if (isset($matchingOptions['returnEntities']) && $matchingOptions['returnEntities']) {
            return $result;
        }

        $context = SerializationContext::create()->enableMaxDepthChecks();

        if (!empty($groups)) {
            $context->setGroups($groups);
        }

        /**
         * @var Serializer $serializer;
         */
        $serializer = $this->container->get('jms_serializer');
        $serializedEntity = $serializer->serialize($result, $this->getSerializerFormat(), $context);

        $response->setContent($serializedEntity);

        return $response;
    }

    public function baseSerialize($entity, $groups = [], $statusCode = 200)
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $context = SerializationContext::create()->enableMaxDepthChecks();
        if (!empty($groups)) {
            $context->setGroups($groups);
        }
        /**
         * @var Serializer $serializer;
         */
        $serializer = $this->container->get('jms_serializer');

        $serializedEntity = $serializer->serialize($entity, $this->getSerializerFormat(), $context);


        $response->setContent($serializedEntity);

        return $response;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $expr
     * @param ClassMetadata $classMetadata
     * @param $field
     * @param $value
     * @return QueryBuilder
     */
    public function filter(QueryBuilder $queryBuilder, $expr, ClassMetadata $classMetadata, $field, $value)
    {
        $column = substr($field, strpos($field, '.') + 1);
        if (strpos($column, '-to') !== false && substr($column, -3) == '-to') {
            $column = substr($column, 0, -3);
            $field = substr($field, 0, -3);
        }
        if ($classMetadata->hasField($column)) {
            list($operator, $value) = $this->separateOperator($value);
            if ($operator == 'LIKE') {
                $queryBuilder->andWhere($expr->like($field, $expr->literal("%$value%")));
            } else {
                $comparison = new Comparison($field, $operator, $expr->literal($value));
                $queryBuilder->andWhere($comparison);
            }
        } elseif ($classMetadata->hasAssociation($column)) {
            $queryBuilder->andWhere($expr->eq($field, $value));
        }

        return $queryBuilder;
    }

    public function multipleFilter(QueryBuilder $queryBuilder, \Doctrine\ORM\Query\Expr $expr, ClassMetadata $classMetadata, $field, $array)
    {
        $arr = [];

        if ($classMetadata->hasField($field)) {
            foreach ($array as $element) {
                list($operator, $value) = $this->separateOperator($element);
                if ($operator == 'LIKE') {
                    $arr[] = $expr->like('entity.'.$field, $expr->literal("%$value%"));
                } else {
                    $comparison = new Comparison('entity.'.$field, $operator, $value);
                    $arr[] = $comparison;
                }
            }

            $where = call_user_func_array([$expr, 'orX'], $arr);

            $where = $expr->andX(
                $where
            );

            $queryBuilder->andWhere($where);
        }

        return $queryBuilder;
    }

    /**
     * @param $value
     *
     * @return array
     */
    protected function separateOperator($value)
    {
        $operators = array(
            '<>' => Comparison::NEQ,
            '<=' => Comparison::LTE,
            '>=' => Comparison::GTE,
            '<' => Comparison::LT,
            '>' => Comparison::GT,
            '=' => Comparison::EQ,
        );

        if (preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/', $value, $matches)) {
            $operator = isset($operators[$matches[1]]) ? $operators[$matches[1]] : 'LIKE';
            $value = $matches[2];
        } else {
            $operator = 'LIKE';
        }

        return array($operator, $value);
    }

    /**
     * Handle form, this method is used by both POST and PUT action methods.
     *
     * @param Request      $request
     * @param string $formType
     * @param object       $entity
     * @param array        $options
     * @param bool         $cleanForm
     *
     * @return View|Form|\Symfony\Component\Form\FormInterface
     */
    public function handleForm(Request $request,  $formType, $entity, array $options = array(), $cleanForm = false, $dryRun = false)
    {
        $view = new View();
        $context = new Context();
        $context->enableMaxDepth();
        if (isset($options['serializerGroups'])) {
            $context->setGroups($options['serializerGroups']);
        }
        $view->setContext($context);
        $response = $view->getResponse();
        $formOptions = isset($options['formOptions']) ? $options['formOptions'] : array();

        /** @var \Symfony\Component\Form\Form $form */
        $form = $this->getFormFactory()->create( $formType, $entity,
            array_merge(
                array('csrf_protection' => false),
                $formOptions
            )
        );

        if ($cleanForm) {
            $this->cleanForm($request, $form);
        }

        $data = array_merge($request->request->all(), $request->files->all());

        $form->submit($data);

        if ($form->isValid()) {
            if ($dryRun) {
                $view->setData($entity);

                return $view;
            }

            if (array_key_exists('persist', $options) && $options['persist'] === true || array_key_exists('persist', $options) === false) {
                $isEditAction = $entity->getId();
                $statusCode = $isEditAction ? Response::HTTP_OK : Response::HTTP_CREATED;
                /** @var \Doctrine\Common\Persistence\ObjectManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);

                try {
                    $em->flush();
                } catch (\Exception $e) {
                    throw $e;
                }
                $em->refresh($entity);
            }

            $view->setStatusCode($statusCode);
            $view->setData($entity);
        } else {
            $view->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            $errors = $this->serializeFormErrors($form);
            $view->setData(['form' => $errors, 'errors' => $errors['errors']]);
        }

        return $view;
    }

    /**
     * Remove unnecessary fields from form.
     *
     * @param Request $request
     * @param Form    $form
     */
    protected function cleanForm(Request $request, Form $form)
    {
        $allowedField = array_merge(
            array_keys($request->request->all()),
            array_keys($request->files->all())
        );

        $formFields = $form->all();
        foreach ($formFields as $formField) {
            /** @var \Symfony\Component\Form\Form $formField */
            $fieldName = $formField->getName();

            if (!in_array($fieldName, $allowedField)) {
                $form->remove($fieldName);
            }
        }
    }

    public function serializeFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = array();
        $errors['children'] = array();
        $errors['errors'] = array();

        foreach ($form->getErrors() as $error) {
            $message = $error->getMessage();
            preg_match('/\`(.+)\`:(.+)/', $message, $matches);

            if (is_array($matches) && array_key_exists(1, $matches)) {
                $errors['children'][$matches[1]] = trim($matches[2]);
            } else {
                $errors['children'][] = $message;
            }
        }

        $errors['children'] = array_merge(
            $errors['children'],
            $this->serialize($form)
        );

        return $errors;
    }

    private function serialize(\Symfony\Component\Form\Form $form)
    {
        $local_errors = array();
        if (count($form->getIterator()) <= 0) {
            return;
        }

        foreach ($form->getIterator() as $key => $child) {
            foreach ($child->getErrors() as $error) {
                $local_errors[$key] = $error->getMessage();
            }

            if (count($child->getIterator()) > 0) {
                $local_errors[$key] = $this->serialize($child);
            }
        }

        return $local_errors;
    }

    /**
     * @return Request
     */
    private function getCurrentRequest()
    {
        /**
         * @var RequestStack $requestStack
         */
        $requestStack = $this->container->get('request_stack');

        return $requestStack->getCurrentRequest();
    }

    private function getSerializerFormat()
    {
        $requset = $this->getCurrentRequest();

        $format = $requset->get('_format');

        $format = isset($format)? $format : 'json';

        return $format;
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    protected function getFormFactory()
    {
        return $this->get('form.factory');
    }
}