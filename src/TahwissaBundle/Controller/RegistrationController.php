<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use TahwissaBundle\Entity\User;
use TahwissaBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $user->setUsername($user->getEmail());
            $user->setPlainPassword($user->getPassword());
            $user->setEnabled(1);
            $em->persist($user);
            $em->flush();
        }

        return $this->render("@Tahwissa/Default/register.html.twig", [
            "form" => $form->createView(),
        ]);
    }

}
