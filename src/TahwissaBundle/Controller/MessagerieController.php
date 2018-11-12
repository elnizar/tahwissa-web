<?php

namespace TahwissaBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TahwissaBundle\Entity\Messagerie;
use TahwissaBundle\Form\MessagerieType;
class MessagerieController extends Controller
{
    /**
     * @Route("/membre/myMessages/addMessage", name="add_message")
     */
    public function addAction(Request $r)
    {

            $messagerie = new Messagerie();

            $messagerie->setDateHeureEnvoi(new \DateTime());

            $form = $this->createForm(MessagerieType::class, $messagerie);
            $form->handleRequest($r);

            if (($form->isValid()) && ($form->isSubmitted())) {

                //Utilisateur courant
                $userManager = $this->get('fos_user.user_manager');
                $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));

                $em= $this->getDoctrine()->getEntityManager();

                $em->persist($messagerie);
                $em->flush();

                return new Response("Message envoyé!");
            }
            return $this->render("@Tahwissa/Membre/Messagerie/envoyer.html.twig", array("form" => $form->createView()));


    }


//

    /**
     * @Route("/admin/myMessages/addMessage", name="new_message")
     */
    //  public function newAction(Request $r)
    // {

    //   $messagerie = new Messagerie();

    //   $messagerie->setDateHeureEnvoi(new \DateTime());

    //   $form = $this->createForm(MessagerieType::class, $messagerie);
    //    $form->handleRequest($r);

    //   if (($form->isValid()) && ($form->isSubmitted())) {

    //        //Utilisateur courant
    //        $userManager = $this->get('fos_user.user_manager');
    //       $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));

    //       $em= $this->getDoctrine()->getEntityManager();

    //      $em->persist($messagerie);
    //       $em->flush();

    //      return new Response("Message envoyé!");
    //   }
    //   return $this->render("@Tahwissa/Admin/Messagerie/envoyer.html.twig", array("form" => $form->createView()));


    //  } 

}
