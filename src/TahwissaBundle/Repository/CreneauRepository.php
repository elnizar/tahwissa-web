<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 10/02/2017
 * Time: 22:29
 */

namespace TahwissaBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CreneauRepository extends EntityRepository
{
    public function findAll()
    {
       $qb= $this->createQueryBuilder("c");
       $qb->orderBy("c.debut","asc");
       return $qb->getQuery()->getResult();
    }
}