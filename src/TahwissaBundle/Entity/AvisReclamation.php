<?php
/**
 * Created by PhpStorm.
 * User: Haythem
 * Date: 09/02/2017
 * Time: 13:53
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;

/**
 * Class AvisReclamation
 * @package TahwissaBundle\Entity
 * @ORM\Entity
 */
class AvisReclamation
{
/**
 * @ORM\Column(type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue
 */
private  $id;

    /**
     * @ORM\Column(type="text")
     */
    private $avis;

    /**
     * @ORM\Column(type="string" , length=255)
     */
    private $motif ;

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
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * @param mixed $avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;
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


}