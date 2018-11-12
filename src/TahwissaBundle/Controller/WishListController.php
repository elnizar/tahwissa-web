<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TahwissaBundle\Entity\WishList;
use Doctrine\Common\Collections\ArrayCollection;
use TahwissaBundle\Controller\EvenementController;
class WishListController extends Controller
{
    /**
     * @Route("/membre/ajoutwishlist/{id}", name="ajout_wishlist")
     */
    function ajoutAction(Request $r,$id){
        $evenement = $this->getDoctrine()->getRepository('TahwissaBundle:Evenement')->find($id);
        $ws = $this->getDoctrine()->getRepository('TahwissaBundle:WishList')->checherWishList($this->getUser());
        $ws1=new WishList();
        foreach ($ws as $w){
            if($w->getEvenement()==$evenement){
                $ws1=$w;
            }
        }
        if($ws1->getEvenement()==$evenement){
            return $this->render('@Tahwissa/Membre/WishList/affiche.html.twig', array(
                "user"=> $r->getSession()->get("user"),
                "wishlist"=>$ws
            ));
        }
        else {
            $wishlist = new WishList();
            $user=$this->getUser();
            $em= $this->getDoctrine()->getEntityManager();
            $wish = $this->getDoctrine()->getRepository('TahwissaBundle:WishList')->checherWishList($this->getUser());
            if ( $r->isMethod("get") ) {
                $wishlist->setEvenement($evenement);
                $wishlist->setUser($this->getUser());
                $user->setWishlist($wishlist);
                $em->persist($wishlist);
                $em->merge($user);
                $em->flush();

                return $this->redirect($this->generateUrl('events_show'));
            }
            return $this->render('@Tahwissa/Membre/Evenement/consulter.html.twig', array(
                "user"=> $r->getSession()->get("user"),
            ));
        }

    }
    /**
     * @Route("/membre/wishlist", name="affiche_wishlist")
     */
    function afficheAction(Request $r){

        $user = $this->getUser()->getId();
        $wishlist = $this->getDoctrine()->getRepository('TahwissaBundle:WishList')->checherWishList($user);
        return $this->render('@Tahwissa/Membre/WishList/affiche.html.twig', array(
            "user"=> $r->getSession()->get("user"),
            "wishlist"=>$wishlist
        ));
    }
    /**
     * @Route("/membre/supprimer/{id}", name="supprimmer_wishlist")
     */
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $wishlist = $em->getRepository('TahwissaBundle:WishList')->checherEvent($id);
        $this->getUser()->setWishlist(null);
        $this->deleteEntities($em, $wishlist);
        $em->flush();
        $wish = $em->getRepository('TahwissaBundle:WishList')->findAll();
        if($wish==null){
            return $this->redirectToRoute('events_show');
        }
        else{
            return $this->redirectToRoute('affiche_wishlist');
        }

    }
    protected function deleteEntities($em, $entities)
    {
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
    }

}
