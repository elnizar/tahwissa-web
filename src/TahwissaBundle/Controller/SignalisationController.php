<?php

namespace TahwissaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use TahwissaBundle\Entity\Signalisation;
use TahwissaBundle\Form\SignalisationType;
use Symfony\Component\HttpFoundation\Request;


class SignalisationController extends Controller
{
    /**
     * @Route("/membre/signalisation", name="signaler_membre")
     */
    public function addAction(Request $r/*,$id*/)
    {


            //creation de entityManager
            $em = $this->getDoctrine()
                ->getManager();

            $signal = new Signalisation();

            $form = $this->createForm(SignalisationType::class, $signal);
            $form->handleRequest($r);

        //Utilisateur courant
        $userManager = $this->get('fos_user.user_manager');
        $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));

            if ($form->isValid()) {

            // profil a signalé || id: 2
                $id = 5; // apres avoir ajouter l'id comme param, supp cette ligne
                $profil =$this->getDoctrine()->getRepository("TahwissaBundle:User")->find($id);

                $nbSignals = $profil->getNombreSignalisations();
                $profil->setNombreSignalisations($nbSignals+1);

                if($nbSignals == 10)
                    $profil->setBanned(1);

                $signal->setUser($profil);


                $em->merge($profil);


                $em->persist($signal);
                $em->flush();
                return new Response("Profil signalé!!");
            }
            return $this->render("TahwissaBundle:Membre/Signalisation:signalisation.html.twig", array(
                "form" => $form->createView(),'user'=>$this->getUser()
            ));

    }
    /**
    * @Route("/admin/signaler/afficher", name="afficher_signal")
    */
    function afficherAction(Request $request)
    {
        $signaler = $this->getDoctrine()
            ->getRepository('TahwissaBundle:Signalisation')
            ->findAll();
        return $this->render('@Tahwissa/Admin/Signalisation/affiche.html.twig', array(
            "signale" => $signaler,
            "user" => $request->getSession()->get("user")
        ));
    }
    /**
     * @Route("/admin/bannir/{id}", name="bannir_membre")
     */
    function bannirAction(Request $request,$id)
    {
        $utilisateur = $this->getDoctrine()
            ->getRepository('TahwissaBundle:User')
            ->findAll();
            $us = $this->getDoctrine()
                ->getRepository('TahwissaBundle:User')
                ->find($id);
            $us->setBanned(1);
            $em= $this->getDoctrine()->getEntityManager();
            $em->merge($us);
            $em->flush();
            $signalisation = $this->getDoctrine()
                ->getRepository('TahwissaBundle:Signalisation')
                ->checherUser($us->getId())
            ;
            foreach ($signalisation as $s){
            $em->remove($s);
    }
            $em->flush();

            return $this->render('@Tahwissa/Admin/Signalisation/bannir.html.twig', array(
                "utilisateur" => $utilisateur,
                "user" => $request->getSession()->get("user")
            ));
    }
}
