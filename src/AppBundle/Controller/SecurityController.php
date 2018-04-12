<?php

namespace AppBundle\Controller;

use AppBundle\Form\SignInForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function indexAction()
    {
        $form = $this->createForm(SignInForm::class);

        return $this->render('loginpage/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logoutActiot(Request $request)
    {
        return $this->redirectToRoute('homepage');
    }
}
