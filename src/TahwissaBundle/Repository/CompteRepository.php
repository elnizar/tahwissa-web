<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-11
 * Time: 13:05
 */

namespace TahwissaBundle\Repository;
use Doctrine\ORM\EntityRepository;
use TahwissaBundle\Entity\Compte;

class CompteRepository extends EntityRepository
{
    public function chercherIdentifiant($identifiant){
        $qb = $this->createQueryBuilder('p');
            $qb->where("p.identifiant = :identifiant")
                ->setParameters(array("identifiant"=>$identifiant));
        return $qb->getQuery()->getResult();
    }

}