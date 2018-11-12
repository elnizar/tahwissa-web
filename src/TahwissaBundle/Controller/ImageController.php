<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    /**
     * @Route("/membre/deleteImage/{id}", name="delete_image")
     */
    public function deleteAction($id){
        $image= $this->getDoctrine()->getRepository("TahwissaBundle:Image")->find($id);
        //var_dump($image);
        $idImg= $image->getId();
        $em= $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();
        return new Response($idImg);
    }
}
