<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/02/2017
 * Time: 18:40
 */

namespace TahwissaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 */

class Messagerie
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
     * @ORM\Column(name="ContenuMsg", type="text")
     */
    private $contenu;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateHeureEnvoi", type="datetime")
     */
    private $DateHeureEnvoi;

    /**
     * Messagerie constructor.
     */
    public function __construct()
    {
        $this->DateHeureEnvoi = new \Datetime();

    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return \DateTime
     */
    public function getDateHeureEnvoi()
    {
        return $this->DateHeureEnvoi;
    }

    /**
     * @param \DateTime $DateHeureEnvoi
     */
    public function setDateHeureEnvoi($DateHeureEnvoi)
    {
        $this->DateHeureEnvoi = $DateHeureEnvoi;
    }

}