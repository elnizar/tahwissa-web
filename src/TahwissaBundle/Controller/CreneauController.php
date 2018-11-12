<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CreneauController extends Controller
{
    /**
     * @Route("/membre/deleteCreneau/{id}", name="delete_creneau")
     */
    public function deleteAction($id){
        $creneau= $this->getDoctrine()->getRepository("TahwissaBundle:Creneau")->find($id);
        //var_dump($creneau);
        $idCrn= $creneau->getId();
        $em= $this->getDoctrine()->getManager();
        $em->remove($creneau);
       $em->flush();
        return new Response($idCrn);
    }
}
