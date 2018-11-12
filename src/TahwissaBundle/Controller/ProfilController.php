<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use TahwissaBundle\Entity\User;
use TahwissaBundle\Form\ImageUserType;
use TahwissaBundle\Form\UserEditType;
use TahwissaBundle\Form\UserPictureForm;
use TahwissaBundle\Form\UserType;

class ProfilController extends BaseController
{


    /**
     * @Route("/membre/profile/recherche/{id}", name="rech_membre")
     */
    public  function rechAction(Request $r, $id)
    {
        $i=0;
        $participation = $this->getDoctrine()->getRepository('TahwissaBundle:Participation')->checherParticipant($this->getUser()->getId());
        if($participation!=null){
            foreach ($participation as $p){
                $i++;
            }
        }
        else{
            $i=0;
        }
        $utilisateur = $this->getDoctrine()
            ->getRepository('TahwissaBundle:User')
            ->find($id);
        return $this->render('@Tahwissa/Membre/Compte/rechercher.html.twig', array(
            "usere" => $utilisateur,
            "user" => $r->getSession()->get("user"),
            "nb"=>$i

        ));
    }

    /**
     *@Route("/membre/profile", name="voir_profil")
     */
    public  function afficheAction(Request $r)
    {
        $i=0;
        $participation = $this->getDoctrine()->getRepository('TahwissaBundle:Participation')->checherParticipant($this->getUser()->getId());
        if($participation!=null){
            foreach ($participation as $p){
                $i++;
            }
        }
        else{
            $i=0;
        }
        if ( $r->isMethod("post") ) {
            $chaine = $r->get('rechrche');
            $test = explode(" ", $chaine);
            if(strlen($chaine)==0){
                return $this->render('TahwissaBundle:Membre:testHtml.html.twig', array(
                    "user"=> $r->getSession()->get("user"),
                    "nb"=>$i
                ));
            }
            else if(sizeof($test)==1){
                $utilisateur = $this->getDoctrine()->getRepository('TahwissaBundle:User')->chercherUs($test[0]);
                if($utilisateur==null){
                    return $this->render('TahwissaBundle:Membre:testHtml.html.twig', array(
                        "user"=> $r->getSession()->get("user"),
                        "nb"=>$i
                    ));
                }
                return $this->render('TahwissaBundle:Membre:afficherprofile.html.twig', array(
                    "user" => $r->getSession()->get("user"),
                    "utilisateur" => $utilisateur,
                    "nb"=>$i
                ));
            }
            else{
                $utilisateur = $this->getDoctrine()->getRepository('TahwissaBundle:User')->chercherUser($test[0], $test[1]);
                if($utilisateur==null){
                    return $this->render('TahwissaBundle:Membre:testHtml.html.twig', array(
                        "user"=> $r->getSession()->get("user"),
                        "nb"=>$i
                    ));
                }
                return $this->render('TahwissaBundle:Membre:afficherprofile.html.twig', array(
                    "user" => $r->getSession()->get("user"),
                    "utilisateur" => $utilisateur,
                    "nb"=>$i
                ));
            }

        }
        return $this->render('TahwissaBundle:Membre:testHtml.html.twig', array(
            "user"=> $r->getSession()->get("user"),
            "nb"=>$i
        ));
    }

    /**
     * @Route("/membre/profil/edit", name="edit_profile")
     */
    public function editAction (Request $r){

        $user = $this->getUser();
        $form= $this->createForm(UserEditType::class,$user);
        $form->handleRequest($r);

        if ( ($form->isValid()) && ($form->isSubmitted()) )
        {
            $em = $this->getDoctrine()->getManager();
            $user->setPlainPassword($user->getPassword());
            $em->merge($user);
            $em->flush();
        }
        return $this->render("@Tahwissa/Membre/Profil/edit.html.twig",array("form"=>$form->createView(),
            "user"=>$user));
    }

    /**
     * @Route("/membre/profil/picture", name="edit_pic")
     */
    public function profilePicAction (Request $request){

        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($user);
            $em->flush();

            return $this->render('TahwissaBundle:Membre:testtt.html.twig', array(
                'form' => $form->createView(),
                "user"=> $request->getSession()->get("user"),
            ));
        }

        return $this->render('TahwissaBundle:Membre:testtt.html.twig', array(
            'form' => $form->createView(),
            "user"=> $request->getSession()->get("user"),
        ));

    }
}
