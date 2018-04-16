<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsPageController extends Controller
{
    /**
     * @Route("/settings", name="settings")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'POST' == $request->getMethod()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();
        }


        return $this->render('settingpage/index.html.twig', ['form' => $form->createView()]);
    }
}
