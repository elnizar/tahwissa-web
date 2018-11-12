<?php

namespace TahwissaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation")
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\ParticipationRepository")
 */
class Participation
{
    public static $EN_ATTENTE="En attente";
    public static $REMBOURSE="Remboursé";
    public static $EFFECTUE="Effectué";
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateHeureParticipation", type="datetime")
     */
    private $dateHeureParticipation;

    /**
     * @var string
     *
     * @ORM\Column(name="statutPaiement", type="string", length=255)
     */
    private $statutPaiement;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $nombreDePlaces;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement")
     */
    private $evenement;


    /**
     * Participation constructor.
     */
    public function __construct()
    {
        $this->setDateHeureParticipation(new \DateTime());
        $this->setStatutPaiement(Participation::$EN_ATTENTE);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateHeureParticipation()
    {
        return $this->dateHeureParticipation;
    }

    /**
     * @param \DateTime $dateHeureParticipation
     */
    public function setDateHeureParticipation($dateHeureParticipation)
    {
        $this->dateHeureParticipation = $dateHeureParticipation;
    }

    /**
     * @return string
     */
    public function getStatutPaiement()
    {
        return $this->statutPaiement;
    }

    /**
     * @param string $statutPaiement
     */
    public function setStatutPaiement($statutPaiement)
    {
        $this->statutPaiement = $statutPaiement;
    }

    /**
     * @return int
     */
    public function getNombreDePlaces()
    {
        return $this->nombreDePlaces;
    }

    /**
     * @param int $nombreDePlaces
     */
    public function setNombreDePlaces($nombreDePlaces)
    {
        $this->nombreDePlaces = $nombreDePlaces;
    }

    /**
     * @return mixed
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param mixed $participant
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;
    }

    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }

}

