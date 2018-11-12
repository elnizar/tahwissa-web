<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/index")
     * @Route("/index", name="home_member")
     */
    public function indexAction(Request $r)
    {
        $session= $r->getSession();
        return $this->render('@Tahwissa/Membre/index.html.twig',array("user"=>$session->get("user")));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin")
     * @Route("/admin", name="home_admin")
     */
    public function adminAction(Request $r)
    {
        return $this->render("@Tahwissa/Admin/index.html.twig");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/connexion")
     */
    public function loginAction()
    {
        return $this->render("@Tahwissa/Default/index.html.twig");
    }

    /**
     * @Route("/modal")
     */
    public function modalTestAction(Request $r)
    {
        $session= $r->getSession();
        return $this->render('@Tahwissa/Membre/Evenement/Camping/testModal.html.twig',array("user"=>$session->get("user")));
    }
    /**
     * @Route("/test")
     */
    public function TestAction(Request $r)
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
        $session= $r->getSession();
        return $this->render('@Tahwissa/Membre/testHtml.html.twig',array("user"=>$session->get("user"),
                "nb"=>$i
        ));
    }
}
