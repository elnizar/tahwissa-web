<?php
/**
 * Created by PhpStorm.
 * User: esprit
 * Date: 08/02/2017
 * Time: 19:04
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Achat
 * @package TahwissaBundle\Entity
 * @ORM\Entity
 */
class Achat
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateHeureAchat;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $statut;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="membre", referencedColumnName="id")
     */
    protected $membre;
    /**
     * @ORM\OneToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="Article", referencedColumnName="id")
     */
    protected $article;

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
    public function getDateHeureAchat()
    {
        return $this->dateHeureAchat;
    }

    /**
     * @param mixed $dateHeureAchat
     */
    public function setDateHeureAchat($dateHeureAchat)
    {
        $this->dateHeureAchat = $dateHeureAchat;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param mixed $membre
     */
    public function setMembre($membre)
    {
        $this->membre = $membre;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }


}