<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-10
 * Time: 21:54
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\CompteRepository")
 * @ORM\Table(name="compte")
 */
class Compte
{
    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $passcode;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateCreation;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateModification;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $solde=0;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifiant;
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     */
    protected $user;

    /**
     * Compte constructor.
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
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
    public function getPasscode()
    {
        return $this->passcode;
    }

    /**
     * @param mixed $passcode
     */
    public function setPasscode($passcode)
    {
        $this->passcode = $passcode;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param mixed $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
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
     * @return mixed
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * @param mixed $identifiant
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}