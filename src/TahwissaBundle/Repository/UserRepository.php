<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-12
 * Time: 23:59
 */

namespace TahwissaBundle\Repository;
use Doctrine\ORM\EntityRepository;
use TahwissaBundle\Entity\User;

class UserRepository extends EntityRepository
{
    public function chercherUser($nom,$prenom){

        $qb = $this->createQueryBuilder('p');
        $qb->where("p.nom = :nom")
                ->andWhere("p.prenom = :prenom")
                ->setParameters(array("nom"=>$nom,"prenom"=>$prenom));
        return $qb->getQuery()->getResult();

    }
    public function chercherUs($nom){

        $qb = $this->createQueryBuilder('p');
        $qb->where("p.nom = :nom")
            ->setParameters(array("nom"=>$nom));
        return $qb->getQuery()->getResult();

    }
}