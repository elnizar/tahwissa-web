<?php

namespace TahwissaBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TahwissaBundle\Entity\Creneau;
use TahwissaBundle\Entity\Evenement;
use TahwissaBundle\Entity\Image;
use TahwissaBundle\Entity\Randonnee;
use TahwissaBundle\Entity\Rating;
use TahwissaBundle\Form\RandonneeType;
use TahwissaBundle\Form\RatingType;


class RandonneeController extends Controller
{
    /**
     * @Route("/membre/randonnee/organiser", name="organiser_randonnee")
     */
    public function addAction(Request $r){
        $randonnee= new Randonnee();
        $randonnee->addPhoto(new Image());
        $randonnee->addPlanning(new Creneau());
        $form= $this->createForm(RandonneeType::class,$randonnee);
        $form->handleRequest($r);

        if ( ($form->isValid()) && ($form->isSubmitted()) )
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
            $randonnee->setOrganisateur($user);
            $em= $this->getDoctrine()->getEntityManager();
            $photos= $randonnee->getPhotos();
            $planning=$randonnee->getPlanning();
            $randonnee->setPlanning(new ArrayCollection());
            //var_dump($photos);
            $randonnee->setPhotos(new ArrayCollection());
            $em->persist($randonnee);
            //$photos = $randonnee->getPhotos();

            foreach ($photos as $p) {
                if ($p->getChemin() instanceof UploadedFile) {
                    $file = $p->getChemin();
                    //var_dump($file);
                    //var_dump(strpos($file->getMimeType(),"image"));
                    if ((strpos($file->getMimeType(),"image")==false) && (strpos($file->getMimeType(),"image")!=0)){
                        $err = new FormError("Le fichier uploadé n'est pas une image");
                        $form->addError($err);

                        return $this->render("@Tahwissa/Membre/Evenement/Randonnee/organiser.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user")));
                    }
                    $fileName=(uniqid().'.'.$file->guessExtension());
                    //var_dump($fileName);
                    $file->move("images/evenements",$fileName);
                    $p->setChemin($fileName);
                    $p->setEvenement($randonnee);
                    $em->persist($p);
                    //var_dump($p);
                }
            }
            foreach ($planning as $p){
                $p->setEvenement($randonnee);
                $em->persist($p);
            }
            $em->flush();

            return $this->redirectToRoute("myEvents");
        }
        return $this->render("@Tahwissa/Membre/Evenement/Randonnee/organiser.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user")));
    }
    /**
     * @Route("/membre/mesRandonnees", name="mes_randonnees")
     */
    public function mesRandonnesAction(Request $r){
        $userManager = $this->get('fos_user.user_manager');
        $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
        $randonnees= $this->getDoctrine()->getRepository("TahwissaBundle:Randonnee")->findRandonneesByOrganisateur($user);
       // var_dump($randonnees);
        return new Response(json_encode($randonnees));
    }


    /**
     * @Route("/randonnee/{id}", name="details_randonnee")
     */
    public function detailsRandonneeAction($id,Request $r){
        $userManager = $this->get('fos_user.user_manager');
        $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
        $randonnee = $this->getDoctrine()->getRepository("TahwissaBundle:Randonnee")->find($id);
        $rating = $this->getDoctrine()->getRepository("TahwissaBundle:Rating")->getByUserAndEvent(
            $user,$randonnee
        );
        $hasParticipated= $this->getDoctrine()->getRepository("TahwissaBundle:Participation")->hasParticipated($user,$randonnee);
        $hasAlreadyVoted=true;
        if ($rating==null){
            $rating=new Rating();
            $hasAlreadyVoted=false;
        }
        else{
            $oldValue=$rating->getValue();
        }
        $form= $this->createForm(RatingType::class,$rating);
        $form->handleRequest($r);

        if ( ($form->isValid()) && ($form->isSubmitted()) )
        {
            $em=$this->getDoctrine()->getManager();
            $nouveauRating=0;
            $ratingActuel= $randonnee->getRating();
            $nombreRates=$randonnee->getNombreRates();
            if ($hasAlreadyVoted){
                $nouveauRating=(($ratingActuel)*$nombreRates-$oldValue+$rating->getValue())/$nombreRates;
                $randonnee->setRating($nouveauRating);
                $em->merge($rating);
                $em->merge($randonnee);
                $em->flush();
            }
            else{
                $nouveauRating=($ratingActuel*$nombreRates+$rating->getValue())/($nombreRates+1);
                $randonnee->setRating($nouveauRating);
                $randonnee->setNombreRates($nombreRates+1);
                $rating->setUser($user);
                $rating->setEvent($randonnee);
                $em->persist($rating);
                $em->merge($randonnee);
                $em->flush();
            }
        }
        return $this->render("@Tahwissa/Membre/Evenement/Randonnee/details.html.twig",["user"=>$user,
            "randonnee"=>$randonnee,"rating"=>$form->createView(),"hasParticipated"=>$hasParticipated]);
    }

    /**
     * @Route("/randonnee/supprimer/{id}", name="supprimer_randonnee")
     */
    public function supprimerRandonneAction($id,Request $r){
        $user= $r->getSession()->get("user");
        $randonnee = $this->getDoctrine()->getRepository("TahwissaBundle:Randonnee")->find($id);
        if ($randonnee->getOrganisateur()->getEmail()==$user->getEmail()){
            $em=$this->getDoctrine()->getManager();
            $em->remove($randonnee);
            $em->flush();
        }
        return $this->redirectToRoute("myEvents");
    }

    /**
     * @Route("/membre/randonnee/modifier/{id}", name="modifier_randonnee")
     */
    public function updateAction($id,Request $r){

        $user=$r->getSession()->get("user");
        $randonnee=$this->getDoctrine()->getRepository("TahwissaBundle:Randonnee")->find($id);
        //var_dump($randonnee);
        $dateTest= $randonnee->getDateHeureDepart();

        if ($randonnee==null){
            return $this->render("@Tahwissa/Membre/errorPage.html.twig",["message"=>"Evènement introuvable","user"=>$user]);
        }
        if ( ($randonnee->getOrganisateur()->getEmail()!=$user->getEmail()) || ($randonnee->getStatut()==Evenement::$ACCEPTE) ){
            return $this->render("@Tahwissa/Membre/errorPage.html.twig",["message"=>"Vous ne pouvez pas modifier cet évènement","user"=>$user]);
        }
        $photos= $randonnee->getPhotos();
        $planning=$randonnee->getPlanning();
        $randonnee->setPhotos(new ArrayCollection());
        $randonnee->setPlanning(new ArrayCollection());
        $form= $this->createForm(RandonneeType::class,$randonnee);
        $form->handleRequest($r);

        if (  ($form->isSubmitted()) )
        {
            var_dump($randonnee->getDateHeureDepart());
            if ($form->isValid()){
            $userManager = $this->get('fos_user.user_manager');
            $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
            $randonnee->setOrganisateur($user);
            $em= $this->getDoctrine()->getEntityManager();
            $photos= $randonnee->getPhotos();
            $planning=$randonnee->getPlanning();
            $randonnee->setPlanning(new ArrayCollection());
            //var_dump($photos);
            $randonnee->setPhotos(new ArrayCollection());
            $em->merge($randonnee);
            //$photos = $randonnee->getPhotos();

            foreach ($photos as $p) {
                if ($p->getChemin() instanceof UploadedFile) {
                    $file = $p->getChemin();
                    //var_dump($file);
                    //var_dump(strpos($file->getMimeType(),"image"));
                    if (strpos($file->getMimeType(),"image")!=0){
                        $err = new FormError("Le fichier uploadé n'est pas une image");
                        $form->addError($err);

                        return $this->render("@Tahwissa/Membre/Evenement/Randonnee/organiser.html.twig",array("form"=>$form->createView()
                        ,"user"=>$r->getSession()->get("user"),
                            "photos"=>$photos,"planning"=>$planning));
                    }
                    $fileName=(uniqid().'.'.$file->guessExtension());
                    //var_dump($fileName);
                    $file->move("images/evenements",$fileName);
                    $p->setChemin($fileName);
                    $p->setEvenement($randonnee);
                    $em->persist($p);
                    //var_dump($p);
                }
            }
            foreach ($planning as $p){
                $p->setEvenement($randonnee);
                $em->persist($p);
            }
            $em->flush();

            return $this->redirectToRoute("myEvents");
            }
        }
        return $this->render("@Tahwissa/Membre/Evenement/Randonnee/modifier.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user"),
            "photos"=>$photos,"planning"=>$planning,"id_randonnee"=>$id,"randonnee"=>$randonnee));
    }

}
