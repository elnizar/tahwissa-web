<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TahwissaBundle\Entity\Compte;
use TahwissaBundle\Entity\Evenement;
use TahwissaBundle\Entity\Participation;

class ParticipationController extends Controller
{
    /**
     *@Route("/membre/participer/{id}", name="part_event")
     */
    function particperAction($id,Request $r){
        $test=$this->getUser()->getCompte();
        $us=$this->getUser();
        $em= $this->getDoctrine()->getEntityManager();
        $compte = $this->getDoctrine()->getRepository('TahwissaBundle:Compte')->find($test);
        $solde=$compte->getSolde();
        $evenement = $this->getDoctrine()->getRepository('TahwissaBundle:Evenement')->find($id);
        $nbplacerestant=$evenement->getNombrePlaces() - $evenement->getNombrePlacesPrises();
        $prix=$evenement->getFrais();
        $choixnbplaces = $r->get('nbplaces');
        $mdp = $r->get('mdp');
        $pswd=$compte->getPasscode();
        $prixtotale=$choixnbplaces*$prix;
        $part =$this->getDoctrine()->getRepository('TahwissaBundle:Participation')->checherParticipant($this->getUser());
        $part2=new Participation();
        foreach ($part as $p){
            if($p->getEvenement()==$evenement)
            {
                $part2=$p;
            }
        }

        if($test != null){
            if($part2->getNombreDePlaces()==null){
                if ( $r->isMethod("post") ) {
                    if($mdp==$pswd){
                        if( $choixnbplaces>$nbplacerestant and $solde<$prixtotale){
                            $message = "il reste seulement deux places et votre solde est insufissant";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else if($solde<$prixtotale) {
                            $message = "votre solde est insufissant ";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else if($choixnbplaces>$nbplacerestant){
                            $message = "il reste seulement deux places ";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else {
                            $particpation = new Participation();
                            $evenement->setNombrePlacesPrises($evenement->getNombrePlacesPrises()+$choixnbplaces);
                            $particpation->setEvenement($evenement);
                            $particpation->setNombreDePlaces($choixnbplaces);
                            $particpation->setStatutPaiement('Effectué');
                            $particpation->setParticipant($this->getUser());
                            $compte->setSolde($compte->getSolde()-($choixnbplaces*$prix));
                            $em->persist($particpation);
                            $em->merge($compte);
                            $em->merge($evenement);
                            $us->setParticipation($particpation);
                            $em->merge($us);
                            $em->flush();
                            $prix=0;
                            $choixnbplaces=0;
                            return $this->render('@Tahwissa/Membre/participerpdf.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "nbplaces"=>$choixnbplaces,
                                "participation"=>$particpation
                            ));
                        }
                    }
                    else {
                        $message="mot de pass incorrect";
                        return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                            "user"=> $r->getSession()->get("user"),
                            "message"=> $message,
                            "evenement"=>$evenement,
                            "prix"=> $prix,
                            "nbplaces"=>$choixnbplaces
                        ));
                    }
                }
                else {
                    $message="";
                    return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                        "user"=> $r->getSession()->get("user"),
                        "prix"=> $prix,
                        "nbplaces"=>$choixnbplaces,
                        "message"=>$message,
                        "evenement"=>$evenement
                    ));
                }
            }
            else if($part2->getNombreDePlaces()==3) {
                return $this->render('@Tahwissa/Membre/errorPage.html.twig', array(
                    "user"=> $r->getSession()->get("user"),
                    "message"=> "vous avez déja reservez 3 places "
                ));
            }
            else{
                if ( $r->isMethod("post") ) {
                    if ( $mdp == $pswd){
                        if( $choixnbplaces>$nbplacerestant and $solde<$prixtotale){
                            $message = "il reste seulement deux places et votre solde est insufissant";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else if($solde<$prixtotale) {
                            $message = "votre solde est insufissant ";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else if($choixnbplaces>$nbplacerestant){
                            $message = "il reste seulement deux places ";
                            return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "message"=> $message,
                                "evenement"=>$evenement,
                                "prix"=> $prix,
                                "nbplaces"=>$choixnbplaces
                            ));
                        }
                        else{
                            $part2->setEvenement($evenement);
                            $part2->setNombreDePlaces($part2->getNombreDePlaces()+$choixnbplaces);
                            $em->merge($part2);
                            $em->flush();
                            return $this->render('@Tahwissa/Membre/participerpdf.html.twig', array(
                                "user"=> $r->getSession()->get("user"),
                                "nbplaces"=>$choixnbplaces,
                                "participation"=>$part2

                            ));
                        }

                    }
                    else{
                        $message="mot de pass incorrect";
                        return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                            "user"=> $r->getSession()->get("user"),
                            "message"=> $message,
                            "evenement"=>$evenement,
                            "prix"=> $prix,
                            "nbplaces"=>$choixnbplaces
                        ));
                    }

                }
                else{
                    $message="";
                    return $this->render('@Tahwissa/Membre/Participation/participer.html.twig', array(
                        "user"=> $r->getSession()->get("user"),
                        "prix"=> $prix,
                        "nbplaces"=>$choixnbplaces,
                        "message"=>$message,
                        "evenement"=>$evenement
                    ));
                }

            }
        }
        else{
            return $this->render('@Tahwissa/Membre/errorPage.html.twig', array(
                "user"=> $r->getSession()->get("user"),
                "message"=> "vous n'avez pas un compte"
            ));
        }

    }
    /**
     * @Route("/membre/genrate/{id}", name="generate_pdf")
     */
    function genrateAction($id)
    {
        $part =$this->getDoctrine()->getRepository('TahwissaBundle:Participation')->checherParticipant($this->getUser());
        $participation=null;
        $evenement = $this->getDoctrine()->getRepository('TahwissaBundle:Evenement')->find($id);
        foreach ($part as $p){
            if($p->getEvenement()==$evenement and $p->getParticipant()==$this->getUser())
            {
                $participation=$p;
            }
            else{
                $participation=null;
            }
        }
        $user=$this->getUser()->getParticipation();
        $nbplaces=$participation->getNombreDePlaces();
        $nom=$this->getUser().$participation->getId().$nbplaces;
        $this->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'TahwissaBundle:Membre:participerpdf.html.twig',
                array(
                    "user"=>$user,
                    "nbplaces"=>$nbplaces,
                    "participation"=>$participation
                )
            ),
            "C:/Users/Elhraiech Nizar/Desktop/Pdf/".$nom.".pdf"
        );
        return $this->render('@Tahwissa/Membre/index.html.twig', array(
            "user"=>$user,
        ));
    }
    /**
     *@Route("/membre/particpation/lister", name="lister_part")
     */
    function listerAction(Request $r){
        $user = $this->getUser();
        $paticipation =  $this->getDoctrine()->getRepository('TahwissaBundle:Participation')->checherParticipant($user->getId());
        return $this->render('@Tahwissa/Membre/Participation/lister.html.twig', array(
            "user"=>$user,
            "participation"=>$paticipation
        ));
    }

}
