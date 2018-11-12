<?php

namespace TahwissaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TahwissaBundle\Entity\Camping;
use TahwissaBundle\Entity\Evenement;
use TahwissaBundle\Entity\WishList;


class EvenementController extends Controller
{
    /**
     * @Route("/membre/organiser", name="organiser_event")
     */
    public function organiserAction (Request $r){


        if ($r->isMethod("post"))
        {
            $type=$r->get("type");
            if ($type=="r"){
                return $this->redirectToRoute("organiser_randonnee");
            }
            else{
                return $this->redirectToRoute("organiser_camping");
            }
        }
        return $this->render("@Tahwissa/Membre/Evenement/organiser.html.twig",array(
            "user"=>$r->getSession()->get("user")));

    }
    /**
     * @Route("/membre/myEvents", name="myEvents")
     */
    public function myEventsAction(Request $r){
        $user= $r->getSession()->get("user");
        return $this->render("@Tahwissa/Membre/Evenement/myEvents.html.twig",array(
            "user"=>$r->getSession()->get("user")));
    }

    /**
     * @Route("/events/show", name="events_show")
     */
    public function showEventsAction(Request $r){
        $repo=$this->getDoctrine()->getRepository("TahwissaBundle:Evenement");
        if ($r->isMethod("GET")){
            $page=$r->get("page");
            $orderBy=$r->get("orderBy");
            if ($orderBy==""){
                $orderBy="date";
            }

        }
        else{
            $orderBy="dateAjout";
        }
        $destination=$r->get("destination");
        $page=1;
        $boostedEvents= $repo->getBoosted();
        if ($orderBy=="dateAjout"){
            $events = $repo->getEventsByDestinationOrderByDateAjout($page,$destination);
        }
        else if ($orderBy=="date"){
            $events= $repo->getEventsByDestinationOrderByDate($page,$destination);
            $events= $repo->getEventsByDestinationOrderByDate($page,$destination);
        }
        $totalEventsReturned = $events->getIterator()->count();
        $totalEvents = $events->count();
        $iterator = $events->getIterator();
        $limit = 3;
        $maxPages = ceil($totalEvents / $limit);
        $thisPage = $page;
           // var_dump($events->getIterator());
           // var_dump($maxPages);
        return $this->render("@Tahwissa/Membre/Evenement/consulter.html.twig",array(
            "maxPages"=>$maxPages,
            "thisPage"=>$thisPage,
            "events"=>$iterator,
            "totalEvents"=>$totalEvents,
            "user"=> $r->getSession()->get("user"),
            "boostedEvents"=>$boostedEvents,
            "orderBy"=>$orderBy,
            "destination"=>$destination,
        ));
    }

    /**
     * @Route("/events/addGuide/{id_e}/{id_g}", name="addGuide")
     */
    public function addGuideAction($id_e,$id_g){
        $evenement= $this->getDoctrine()->getRepository("TahwissaBundle:Evenement")->find($id_e);
        $userManager = $this->get('fos_user.user_manager');
        $guide = ($userManager->findUserByEmail($id_g));
        $evenement->setGuide($guide);
        $em =$this->getDoctrine()->getManager();
        $em->merge($evenement);
        $em->flush();
        return $this->redirectToRoute("myEvents");
    }

    /**
     * @Route("/events/boost/{id_event}", name="boost")
     */
    public function boostAction($id_event){
        return new Response($id_event." boosted!");
    }


    /**
     * @Route("/admin/events/demandes", name="demandes")
     */
    public function traiterDemandesOrganisationAction(Request $r){
        $events= $this->getDoctrine()->getRepository("TahwissaBundle:Evenement")->getEnAttente();
        return $this->render("@Tahwissa/Admin/Evenements/traiterDemandes.html.twig",array("events"=>$events));
    }

    /**
     * @Route("/admin/events/details/{id}", name="details_event_admin")
     */
    public function detailsEventAdmin($id){
        $event= $this->getDoctrine()->getRepository("TahwissaBundle:Evenement")->find($id);
        return $this->render("@Tahwissa/Admin/Evenements/details.html.twig",array("event"=>$event));
    }

    /**
     * @Route("/admin/events/accepter/{id}", name="accepter_event")
     */
    public function accepterDemandeAction($id){
        $event= $this->getDoctrine()->getRepository("TahwissaBundle:Evenement")->find($id);
        $event->setStatut(Evenement::$ACCEPTE);
        $em=$this->getDoctrine()->getManager();
        $em->merge($event);
        $em->flush();
        return $this->redirectToRoute("demandes");
    }

    /**
     * @Route("/admin/events/refuser/", name="refuser_event")
     */
    public function refuserDemandeAction(Request $r){
        $id=$r->get("idE");
        $motif=$r->get("motif");

        $event= $this->getDoctrine()->getRepository("TahwissaBundle:Evenement")->find($id);
        $event->setStatut(Evenement::$REFUSE);
        $em=$this->getDoctrine()->getManager();
        $em->merge($event);
        return new Response("Evenement ".$id." refusé. <br> Motif : ".$motif);
        //$em->flush();
        //return $this->redirectToRoute("demandes");
    }

}
