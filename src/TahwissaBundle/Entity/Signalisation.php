<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16/02/2017
 * Time: 18:52
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\SignalisationRepository")
 */
class Signalisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
   private $motif;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * Evenement constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * @param mixed $motif
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;
    }

    /**
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param string $objet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
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