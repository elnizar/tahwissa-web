<?php

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Randonnee
 *
 * @ORM\Table(name="randonnee")
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\RandonneeRepository")
 */
class Randonnee extends Evenement
{

    public static $DIFFICILE="Difficile";
    public static $FACILE="Facile";
    public static $MOYENNE="Moyenne";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulte", type="string", length=255)
     */
    private $difficulte;

    /**
     * @var float
     *
     * @ORM\Column(name="distanceParcourue", type="float")
     */
    private $distanceParcourue;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Randonnee constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return parent::getId();
    }

    /**
     * Set difficulte
     *
     * @param string $difficulte
     *
     * @return Randonnee
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * Get difficulte
     *
     * @return string
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }

    /**
     * Set distanceParcourue
     *
     * @param float $distanceParcourue
     *
     * @return Randonnee
     */
    public function setDistanceParcourue($distanceParcourue)
    {
        $this->distanceParcourue = $distanceParcourue;

        return $this;
    }

    /**
     * Get distanceParcourue
     *
     * @return float
     */
    public function getDistanceParcourue()
    {
        return $this->distanceParcourue;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Randonnee
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function getTypeEvenement(){
        return "randonnee";
    }
    public function __toString()
    {
        return 'Randonnée';
    }
}

