<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-15
 * Time: 03:01
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
/**
 * @ORM\Table(name="wishlist")
 * @ORM\Entity(repositoryClass="TahwissaBundle\Repository\WishListRepository")
 */
class WishList
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateHeureParticipation", type="datetime")
     */
    private $dateAjoutWishList;
    /**
     *@ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $evenement;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * WishList constructor.
     * @param \DateTime $dateAjoutWishList
     */
    public function __construct()
    {
        $this->dateAjoutWishList=new \DateTime();
        $this->evenement = new \Doctrine\Common\Collections\ArrayCollection();

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
    public function getDateAjoutWishList()
    {
        return $this->dateAjoutWishList;
    }

    /**
     * @param \DateTime $dateAjoutWishList
     */
    public function setDateAjoutWishList($dateAjoutWishList)
    {
        $this->dateAjoutWishList = $dateAjoutWishList;
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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
