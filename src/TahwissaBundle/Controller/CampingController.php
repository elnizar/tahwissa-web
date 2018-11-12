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
use TahwissaBundle\Entity\Camping;
use TahwissaBundle\Entity\Rating;
use TahwissaBundle\Form\CampingType;
use TahwissaBundle\Form\RatingType;


class CampingController extends Controller
{
    /**
     * @Route("/membre/camping/organiser", name="organiser_camping")
     */
    public function addAction(Request $r){
        $camping= new Camping();
        $camping->addPlanning(new Creneau());
        $camping->addPhoto(new Image());
        $form= $this->createForm(CampingType::class,$camping);
        $form->handleRequest($r);

        if ( ($form->isValid()) && ($form->isSubmitted()) )
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
            $camping->setOrganisateur($user);
            $em= $this->getDoctrine()->getEntityManager();
            $photos= $camping->getPhotos();
            $planning=$camping->getPlanning();
            $camping->setPlanning(new ArrayCollection());
            //var_dump($photos);
            $camping->setPhotos(new ArrayCollection());
            $em->persist($camping);
            //$photos = $camping->getPhotos();

            foreach ($photos as $p) {
                if ($p->getChemin() instanceof UploadedFile) {
                    $file = $p->getChemin();
                    //var_dump($file);

                    var_dump($file);
                    var_dump($file->getMimeType());
                    var_dump(strpos($file->getMimeType(),"image"));
                    if ((strpos($file->getMimeType(),"image")==false) && (strpos($file->getMimeType(),"image")!=0)){
                        $err = new FormError("Le fichier ".$file->getClientOriginalName()." n'est pas une image");
                        $form->get("photos")->addError($err);

                        return $this->render("@Tahwissa/Membre/Evenement/Camping/organiser.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user")));
                    }
                    $fileName=(uniqid().'.'.$file->guessExtension());
                    //var_dump($fileName);
                    $file->move("images/evenements",$fileName);
                    $p->setChemin($fileName);
                    $p->setEvenement($camping);
                    $em->persist($p);
                    //var_dump($p);
                }
            }
            foreach ($planning as $p){
                $p->setEvenement($camping);
                $em->persist($p);
            }
            $em->flush();

            return $this->redirectToRoute("myEvents");
        }
        return $this->render("@Tahwissa/Membre/Evenement/Camping/organiser.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user")));
    }
    /**
     * @Route("/membre/mesCampings", name="mes_campings")
     */
    public function mesCampingsAction(Request $r){
        $userManager = $this->get('fos_user.user_manager');
        $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
        $campings= $this->getDoctrine()->getRepository("TahwissaBundle:Camping")->findCampingsByOrganisateur($user);
        // var_dump($randonnees);
        return new Response(json_encode($campings));
    }

    /**
     * @Route("/camping/{id}", name="details_camping")
     */
    public function detailsCampingAction($id,Request $r){
        $userManager = $this->get('fos_user.user_manager');
        $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
        $camping = $this->getDoctrine()->getRepository("TahwissaBundle:Camping")->find($id);
        $rating = $this->getDoctrine()->getRepository("TahwissaBundle:Rating")->getByUserAndEvent(
            $user,$camping
        );
        $hasParticipated= $this->getDoctrine()->getRepository("TahwissaBundle:Participation")->hasParticipated($user,$camping);
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
            $ratingActuel= $camping->getRating();
            $nombreRates=$camping->getNombreRates();
            if ($hasAlreadyVoted){
                $nouveauRating=(($ratingActuel)*$nombreRates-$oldValue+$rating->getValue())/$nombreRates;
                $camping->setRating($nouveauRating);
                $em->merge($rating);
                $em->merge($camping);
                $em->flush();
            }
            else{
                $nouveauRating=($ratingActuel*$nombreRates+$rating->getValue())/($nombreRates+1);
                $camping->setRating($nouveauRating);
                $camping->setNombreRates($nombreRates+1);
                $rating->setUser($user);
                $rating->setEvent($camping);
                $em->persist($rating);
                $em->merge($camping);
                $em->flush();
            }
        }
        return $this->render("@Tahwissa/Membre/Evenement/Camping/details.html.twig",["user"=>$user,
        "camping"=>$camping,"rating"=>$form->createView(),"hasParticipated"=>$hasParticipated]);
    }

    /**
     * @Route("/camping/supprimer/{id}", name="supprimer_camping")
     */
    public function supprimerRandonneAction($id,Request $r){
        $user= $r->getSession()->get("user");
        $camping = $this->getDoctrine()->getRepository("TahwissaBundle:Camping")->find($id);
        if ($camping->getOrganisateur()->getEmail()==$user->getEmail()){
            $em=$this->getDoctrine()->getManager();
            $em->remove($camping);
            $em->flush();
        }
        return $this->redirectToRoute("myEvents");
    }

    /**
     * @Route("/membre/camping/modifier/{id}", name="modifier_camping")
     */
    public function updateAction($id,Request $r){

        $user=$r->getSession()->get("user");
        $camping=$this->getDoctrine()->getRepository("TahwissaBundle:Camping")->find($id);

        //var_dump($camping);
        if ($camping==null){
            return $this->render("@Tahwissa/Membre/errorPage.html.twig",["message"=>"Evènement introuvable","user"=>$user]);
        }
        if ( ($camping->getOrganisateur()->getEmail()!=$user->getEmail()) || ($camping->getStatut()==Evenement::$ACCEPTE) ){
            return $this->render("@Tahwissa/Membre/errorPage.html.twig",["message"=>"Vous ne pouvez pas modifier cet évènement","user"=>$user]);
        }
        $photos= $camping->getPhotos();
        $planning=$camping->getPlanning();
        $camping->setPhotos(new ArrayCollection());
        $camping->setPlanning(new ArrayCollection());
        $form= $this->createForm(CampingType::class,$camping);
        $form->handleRequest($r);

        if ( ($form->isValid()) && ($form->isSubmitted()) )
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = ($userManager->findUserByEmail($r->getSession()->get("user")->getEmail()));
            $camping->setOrganisateur($user);
            $em= $this->getDoctrine()->getEntityManager();
            $photos= $camping->getPhotos();
            $planning=$camping->getPlanning();
            $camping->setPlanning(new ArrayCollection());
            //var_dump($photos);
            $camping->setPhotos(new ArrayCollection());
            $em->merge($camping);
            //$photos = $camping->getPhotos();

            foreach ($photos as $p) {
                if ($p->getChemin() instanceof UploadedFile) {
                    $file = $p->getChemin();
                    //var_dump($file);
                    //var_dump(strpos($file->getMimeType(),"image"));
                    if (strpos($file->getMimeType(),"image")!=0){
                        $err = new FormError("Le fichier uploadé n'est pas une image");
                        $form->addError($err);

                        return $this->render("@Tahwissa/Membre/Evenement/Camping/organiser.html.twig",array("form"=>$form->createView()
                        ,"user"=>$r->getSession()->get("user"),
                            "photos"=>$photos,"planning"=>$planning));
                    }
                    $fileName=(uniqid().'.'.$file->guessExtension());
                    //var_dump($fileName);
                    $file->move("images/evenements",$fileName);
                    $p->setChemin($fileName);
                    $p->setEvenement($camping);
                    $em->persist($p);
                    //var_dump($p);
                }
            }
            foreach ($planning as $p){
                $p->setEvenement($camping);
                $em->persist($p);
            }
            $em->flush();

            return $this->redirectToRoute("myEvents");
        }
        return $this->render("@Tahwissa/Membre/Evenement/Camping/modifier.html.twig",array("form"=>$form->createView(),"user"=>$r->getSession()->get("user"),
            "photos"=>$photos,"planning"=>$planning,"id_camping"=>$id,"camping"=>$camping));
    }
}
