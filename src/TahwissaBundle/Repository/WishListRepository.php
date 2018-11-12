<?php
/**
 * Created by PhpStorm.
 * User: Elhraiech Nizar
 * Date: 2017-02-17
 * Time: 04:45
 */

namespace TahwissaBundle\Repository;
use Doctrine\ORM\EntityRepository;

class WishListRepository extends EntityRepository
{
    public function checherWishList($userid){
        $qb = $this->createQueryBuilder('w');
        $qb->where("w.user = :user")
            ->setParameters(array("user"=>$userid));
        return $qb->getQuery()->getResult();
    }
    public function checherEvent($idevenement){
        $qb = $this->createQueryBuilder('w');
        $qb->where("w.evenement = :evenement")
            ->setParameters(array("evenement"=>$idevenement));
        return $qb->getQuery()->getResult();
    }

}