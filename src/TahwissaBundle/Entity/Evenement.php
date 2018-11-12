<?php

namespace TahwissaBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\EvenementRepository")
 * @ORM\Table(name="evenement")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="evenement_type", type="string")
 * @ORM\DiscriminatorMap({"camping" = "Camping", "randonnee" = "Randonnee"})
 */

abstract class Evenement implements \JsonSerializable
{
    public static  $EN_ATTENTE="En attente";
    public static  $ACCEPTE="Accepté";
    public static $REFUSE="Refusé";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="boosted", type="boolean")
     */
    private $boosted=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateHeureDepart", type="datetime")
     */
    private $dateHeureDepart;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;



    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var float
     *
     * @ORM\Column(name="frais", type="float")
     */
    private $frais;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuRassemblement", type="string", length=255)
     */
    private $lieuRassemblement;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePlaces", type="integer")
     */
    private $nombrePlaces;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePlacesPrises", type="integer")
     */
    private $nombrePlacesPrises=0;
    /**
     * @var int
     *
     * @ORM\Column(name="nombreRates", type="integer")
     */
    private $nombreRates=0;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float")
     */
    private $rating=0;

    /**
     * @var string
     *
     * @ORM\Column(name="reglement", type="string", length=255)
     */
    private $reglement;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Creneau", mappedBy="evenement",cascade={"remove"})
     * @ORM\OrderBy({"debut" = "ASC"})
     */
    private $planning;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Image", mappedBy="evenement",cascade={"remove"})
     */
    private $photos;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $organisateur;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $guide;
    /**
     * Evenement constructor.
     */
    public function __construct()
    {
        $this->statut= Evenement::$EN_ATTENTE;
        $this->photos= new ArrayCollection();
        $this->planning=new ArrayCollection();
        $this->setDateCreation(new \DateTime());
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set boosted
     *
     * @param boolean $boosted
     *
     * @return Evenement
     */
    public function setBoosted($boosted)
    {
        $this->boosted = $boosted;

        return $this;
    }

    /**
     * Get boosted
     *
     * @return bool
     */
    public function getBoosted()
    {
        return $this->boosted;
    }

    /**
     * Set dateHeureDepart
     *
     * @param \DateTime $dateHeureDepart
     *
     * @return Evenement
     */
    public function setDateHeureDepart($dateHeureDepart)
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    /**
     * Get dateHeureDepart
     *
     * @return \DateTime
     */
    public function getDateHeureDepart()
    {
        return $this->dateHeureDepart;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Evenement
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set frais
     *
     * @param float $frais
     *
     * @return Evenement
     */
    public function setFrais($frais)
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return float
     */
    public function getFrais()
    {
        return $this->frais;
    }

    /**
     * Set lieuRassemblement
     *
     * @param string $lieuRassemblement
     *
     * @return Evenement
     */
    public function setLieuRassemblement($lieuRassemblement)
    {
        $this->lieuRassemblement = $lieuRassemblement;

        return $this;
    }

    /**
     * Get lieuRassemblement
     *
     * @return string
     */
    public function getLieuRassemblement()
    {
        return $this->lieuRassemblement;
    }

    /**
     * Set nombrePlaces
     *
     * @param integer $nombrePlaces
     *
     * @return Evenement
     */
    public function setNombrePlaces($nombrePlaces)
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    /**
     * Get nombrePlaces
     *
     * @return int
     */
    public function getNombrePlaces()
    {
        return $this->nombrePlaces;
    }

    /**
     * Set nombreRates
     *
     * @param integer $nombreRates
     *
     * @return Evenement
     */
    public function setNombreRates($nombreRates)
    {
        $this->nombreRates = $nombreRates;

        return $this;
    }

    /**
     * Get nombreRates
     *
     * @return int
     */
    public function getNombreRates()
    {
        return $this->nombreRates;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return Evenement
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set reglement
     *
     * @param string $reglement
     *
     * @return Evenement
     */
    public function setReglement($reglement)
    {
        $this->reglement = $reglement;

        return $this;
    }

    /**
     * Get reglement
     *
     * @return string
     */
    public function getReglement()
    {
        return $this->reglement;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Evenement
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return ArrayCollection
     */
    public function getPlanning()
    {
        return $this->planning;
    }

    /**
     * @param ArrayCollection $planning
     */
    public function setPlanning($planning)
    {
        $this->planning = $planning;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param ArrayCollection $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return User
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param User $organisateur
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return mixed
     */
    public  function getTypeEvenement(){
        return "";
    }

    public function removePhoto(Image $photo){
        $this->getPhotos()->removeElement($photo);
    }
    public function addPhoto(Image $photo){
        $this->photos->add($photo);
    }

    public function removePlanning(Creneau $creneau){
        $this->getPlanning()->removeElement($creneau);
    }
    public function addPlanning(Creneau $creneau){
        $this->planning->add($creneau);
        $creneau->setEvenement($this);
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    public function jsonSerialize()
    {

        if (($this->isExpired()) ||($this->getBoosted()==true) ||($this->getStatut()!=Evenement::$ACCEPTE)){
            $canBeBoosted=false;
        }
        else
            $canBeBoosted=true;
        return array(
            'dateCreation' => $this->getDateCreation()->format("d M y H:i:s"),
            'statut'=> $this->getStatut(),
            'destination'=> $this->getDestination(),
            'nombre_places'=> $this->getNombrePlaces(),
            'id'=>$this->getId(),
            "canBeBoosted"=>$canBeBoosted
        );
    }

    /**
     * @return int
     */
    public function getNombrePlacesPrises()
    {
        return $this->nombrePlacesPrises;
    }

    /**
     * @param int $nombrePlacesPrises
     */
    public function setNombrePlacesPrises($nombrePlacesPrises)
    {
        $this->nombrePlacesPrises = $nombrePlacesPrises;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->getDateHeureDepart()>new \DateTime();
    }

    /**
     * @return User
     */
    public function getGuide()
    {
        return $this->guide;
    }

    /**
     * @param User $guide
     */
    public function setGuide($guide)
    {
        $this->guide = $guide;
    }



}

