<?php

namespace TahwissaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TahwissaBundle\Entity\Compte;
use TahwissaBundle\Entity\User;


class CompteController extends Controller
{

    /**
     * @Route("/membre/profile/compte", name="compte")
     */
    public function ajoutAction(Request $r)
    {
        $test=$this->getUser()->getCompte();
        if($test==null){
            $userManager = $this->get('fos_user.user_manager');
            $identifiant ="Abc";
            for ($i = 1; $i <= 10; $i++) {
                $j=random_int(1, 10);
                $identifiant=$identifiant.=$j;
            }
            $rech = $this->getDoctrine()->getRepository('TahwissaBundle:Compte')->chercherIdentifiant($identifiant);
            while($rech!=null){
                $identifiant ="Abc";
                for ($i = 1; $i <= 10; $i++) {
                    $j=random_int(1, 10);
                    $identifiant=$identifiant.=$j;
                }
            }
            $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
            $compte= new Compte();
            if ( $r->isMethod("post") )
            {
                $em= $this->getDoctrine()->getEntityManager();
                $compte->setUser($user);
                $compte->setIdentifiant($identifiant);
                $compte->setPasscode($r->get("mdp"));
                $s = new User();
                $s=$this->getUser();
                $s->setCompte($compte);
                $em->persist($compte);
                $em->merge($s);
                $em->flush();
                return $this->render("@Tahwissa/Membre/Compte/confirmation.html.twig",array("identifiant"=>$identifiant,
                    "user"=> $r->getSession()->get("user"),
                ));
            }
            return $this->render("@Tahwissa/Membre/Compte/compte.html.twig",array(
                "user"=> $r->getSession()->get("user"),
            ));
        }
        else
            return $this->redirectToRoute('erreur', array('message'=>"Vous avez déja un compte"));
    }
    /**
     * @Route("/erreur", name="erreur")
     */
    public function erreurAction(Request $r){
        return $this->render("@Tahwissa/Membre/errorPage.html.twig",array("user"=> $r->getSession()->get("user"),
            'message'=>"Vous avez déja un compte"
        ));
    }
    /**
     * @Route("/membre/confirmation", name="confirmation")
     */
    public function indexAction(Request $r){
        return $this->render("@Tahwissa/Membre/Compte/confirmation.html.twig",array("user"=> $r->getSession()->get("user")));
    }
    /**
     * @Route("/membre/crediter", name="crediter")
     */
    public function crediterAction(Request $r){
        return $this->render("@Tahwissa/Membre/Compte/Crediter.html.twig",array("user"=> $r->getSession()->get("user")));
    }
    /**
     * @Route("/membre/payer", name="payer")
     */
    public function payerAction(Request $r){
        $k=$this->getUser()->getCompte()->getId();
        $em= $this->getDoctrine()->getEntityManager();
        $erreur="";
        if ( $r->isMethod("post") ) {
            $erreur="";
            $compte = $this->getDoctrine()->getRepository('TahwissaBundle:Compte')->find($k);
            $compte->getPasscode();
            if ($compte->getPasscode() == $r->get('mdp')) {
                $compte->setSolde($r->get('number')+$compte->getSolde());
                $compte->getSolde();
                $em->merge($compte);
                $em->flush();
                $erreur="succés de recharge";
            }
            else{
                $erreur="Mot de Pass incorrect";
                return $this->render("@Tahwissa/Membre/Compte/payer.html.twig",array("user"=> $r->getSession()->get("user"),
                    "erreur"=>$erreur,

                ));
            }
        }
        return $this->render("@Tahwissa/Membre/Compte/payer.html.twig",array("user"=> $r->getSession()->get("user"),
            "erreur"=>$erreur,
        ));
    }
    /**
     * @Route("/membre/profile/modifier", name="modifier")
     */
    public function updateAction(Request $r){
        $id=$this->getUser()->getCompte();
        $compte = $this->getDoctrine()->getRepository('TahwissaBundle:Compte')->find($id);
        $message="";
        if ( $r->isMethod("post") )
        {       $message="";
            if ($compte->getPasscode() == $r->get('mdp1')) {
                $compte->setPasscode($r->get('mdp'));
                $em= $this->getDoctrine()->getEntityManager();
                $em->merge($compte);
                $em->flush($compte);
        }
            else{
                $message="Mot de pass incorrect";
                return $this->render("@Tahwissa/Membre/Compte/update.html.twig",array("user"=> $r->getSession()->get("user"),
                    "message"=>$message
                ));
            }
        }
        return $this->render("@Tahwissa/Membre/Compte/update.html.twig",array("user"=> $r->getSession()->get("user"),
            "message"=>$message,
        ));
    }

}
