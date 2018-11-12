<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-18
 * Time: 18:40
 */

namespace TahwissaBundle\Repository;
use Doctrine\ORM\EntityRepository;


class SignalisationRepository extends EntityRepository
{
    public function checherUser($userid){
        $qb = $this->createQueryBuilder('u');
        $qb->where("u.user = :user")
            ->setParameters(array("user"=>$userid));
        return $qb->getQuery()->getResult();
    }

}