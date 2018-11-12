<?php
/**
 * Created by PhpStorm.
 * User: Haythem
 * Date: 09/02/2017
 * Time: 13:01
 */

namespace TahwissaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $traite;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="AvisReclamation")
     * @ORM\JoinColumn(name="avisReclamation", referencedColumnName="id")
     */
    private $avisReclamation ;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="Achat")
     * @ORM\JoinColumn(name="achat", referencedColumnName="id")
     */
    private $achat ;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Participation")
     * @ORM\JoinColumn(name="participation", referencedColumnName="id")
     */
    private $participation ;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * @param mixed $dateEnvoi
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;
    }

    /**
     * @return mixed
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param mixed $objet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
    }

    /**
     * @return mixed
     */
    public function getTraite()
    {
        return $this->traite;
    }

    /**
     * @param mixed $traite
     */
    public function setTraite($traite)
    {
        $this->traite = $traite;
    }

    /**
     * @return mixed
     */
    public function getAvisReclamation()
    {
        return $this->avisReclamation;
    }

    /**
     * @param mixed $avisReclamation
     */
    public function setAvisReclamation($avisReclamation)
    {
        $this->avisReclamation = $avisReclamation;
    }

    /**
     * @return mixed
     */
    public function getAchat()
    {
        return $this->achat;
    }

    /**
     * @param mixed $achat
     */
    public function setAchat($achat)
    {
        $this->achat = $achat;
    }

    /**
     * @return mixed
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @param mixed $participation
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;
    }




}