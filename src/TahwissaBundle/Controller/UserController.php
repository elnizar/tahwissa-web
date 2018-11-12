<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 06/02/2017
 * Time: 09:28
 */

namespace TahwissaBundle\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends  Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/test", name="403_error")
     */
    public function testAction(Request $r){
        $user= $r->getSession()->get("user");
        return $this->render("@Tahwissa/Membre/Evenement/Camping/test.html.twig",array("user"=>$user));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/autocomplete", name="user_autocomplete")
     */
    public function autoCompleteAction(Request $r)
    {
        $term= $r->get("term");
        $names= array();
        $users= $this->getDoctrine()->getRepository("TahwissaBundle:User")
            ->createQueryBuilder("c")
            ->where("c.email LIKE :email")
            ->setParameter("email","%".$term."%")
            ->getQuery()
            ->getResult();
        foreach ($users as $u){
            $names[]=["nom"=>$u->getNom()." ".$u->getPrenom(),"email"=>$u->getEmail(),"adresse"=>$u->getAdresse()];
        }
        $r = new JsonResponse();
        $r->setData($names);
        return $r;
    }
}