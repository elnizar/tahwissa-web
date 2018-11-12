<?php

namespace TahwissaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Camping
 *
 * @ORM\Table(name="camping")
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\CampingRepository")
 */
class Camping extends Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * Camping constructor.
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
     * Set duree
     *
     * @param integer $duree
     *
     * @return Camping
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }
    public function getTypeEvenement(){
        return "randonnee";
    }
    public function __toString()
    {
        return 'Camping';
    }
}

