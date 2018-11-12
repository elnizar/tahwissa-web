<?php

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="chemin", type="string", length=255, unique=true)
     */
    private $chemin;

    /**
     * @var Evenement
     * @ORM\ManyToOne(targetEntity="Evenement")
     */
    private $evenement;

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
     * Set chemin
     *
     * @param string $chemin
     *
     * @return Image
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * @return Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param Evenement $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }



}

