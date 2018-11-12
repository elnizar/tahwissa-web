<?php
namespace TahwissaBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\UserRepository")
 * @Vich\Uploadable
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser

{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $adresse;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $banned=0;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInscription;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $informationPersonnel;

    /**
     * @return mixed
     */
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $prenom;
    /**
     * @ORM\Column(type="integer")
     */
    private $nombreOrganisations=0;
    /**
     * @ORM\Column(type="integer")
     */
    private $nombreSignalisations=0;
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $numeroTelephone;
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $profession;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ratingFlobal=0;
    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $sexe;
    /**
     * @var Compte
     * @ORM\OneToOne(targetEntity="Compte")
     */
    protected $compte;

    /**
     * @var WishList
     * @ORM\OneToOne(targetEntity="WishList")
     * @ORM\JoinColumn(name="wishlist_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $wishlist;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $solde=0;

    /**
     * @var Participation
     * @ORM\ManyToOne(targetEntity="Participation")
     */
    protected $participation;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $chemin="user-icon-6.png";





    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->dateInscription = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * @param mixed $banned
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * @param mixed $dateInscription
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return mixed
     */
    public function getInformationPersonnel()
    {
        return $this->informationPersonnel;
    }

    /**
     * @param mixed $informationPersonnel
     */
    public function setInformationPersonnel($informationPersonnel)
    {
        $this->informationPersonnel = $informationPersonnel;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNombreOrganisations()
    {
        return $this->nombreOrganisations;
    }

    /**
     * @param mixed $nombreOrganisations
     */
    public function setNombreOrganisations($nombreOrganisations)
    {
        $this->nombreOrganisations = $nombreOrganisations;
    }

    /**
     * @return mixed
     */
    public function getNombreSignalisations()
    {
        return $this->nombreSignalisations;
    }

    /**
     * @param mixed $nombreSignalisations
     */
    public function setNombreSignalisations($nombreSignalisations)
    {
        $this->nombreSignalisations = $nombreSignalisations;
    }

    /**
     * @return mixed
     */
    public function getNumeroTelephone()
    {
        return $this->numeroTelephone;
    }

    /**
     * @param mixed $numeroTelephone
     */
    public function setNumeroTelephone($numeroTelephone)
    {
        $this->numeroTelephone = $numeroTelephone;
    }

    /**
     * @return mixed
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param mixed $profession
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    }

    /**
     * @return mixed
     */
    public function getRatingFlobal()
    {
        return $this->ratingFlobal;
    }

    /**
     * @param mixed $ratingFlobal
     */
    public function setRatingFlobal($ratingFlobal)
    {
        $this->ratingFlobal = $ratingFlobal;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return Compte
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * @param Compte $compte
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;
    }

    /**
     * @return WishList
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }

    /**
     * @param WishList $wishlist
     */
    public function setWishlist($wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * @return mixed
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param mixed $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    /**
     * @return Participation
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @param Participation $participation
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;
    }

    /**
     * @return string
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * @param string $chemin
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;
    }

// ..... other fields

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255,options={"default" : "user-icon-6.png"},nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

}