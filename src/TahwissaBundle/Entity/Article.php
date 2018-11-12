<?php
/**
 * Created by PhpStorm.
 * User: esprit
 * Date: 08/02/2017
 * Time: 19:05
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 * @package TahwissaBundle\Entity
 * @ORM\Entity
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $libelle;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $livre;
    /**
     * @ORM\Column(type="decimal")
     */
    protected $prix;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $usage;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $vendu;
    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="membre_id", referencedColumnName="id")
     */
    protected $membre_id;

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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getLivre()
    {
        return $this->livre;
    }

    /**
     * @param mixed $livre
     */
    public function setLivre($livre)
    {
        $this->livre = $livre;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param mixed $usage
     */
    public function setUsage($usage)
    {
        $this->usage = $usage;
    }

    /**
     * @return mixed
     */
    public function getVendu()
    {
        return $this->vendu;
    }

    /**
     * @param mixed $vendu
     */
    public function setVendu($vendu)
    {
        $this->vendu = $vendu;
    }

    /**
     * @return mixed
     */
    public function getMembreId()
    {
        return $this->membre_id;
    }

    /**
     * @param mixed $membre_id
     */
    public function setMembreId($membre_id)
    {
        $this->membre_id = $membre_id;
    }


}