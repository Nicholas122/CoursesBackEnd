<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationForm;
use AppBundle\Form\SignInForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();
        }

        return $this->render('registrationpage/index.html.twig', ['form' => $form->createView()]);
    }

}
