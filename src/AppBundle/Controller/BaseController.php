<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getRepository($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }
}