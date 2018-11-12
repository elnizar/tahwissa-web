<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 09/02/2017
 * Time: 20:06
 */

namespace TahwissaBundle\Repository;


class CampingRepository  extends \Doctrine\ORM\EntityRepository
{
    public function getBoosted(){
        $qb= $this->createQueryBuilder("r");
        return $qb->where("r.boosted=true")->andWhere("r.statut='Accepté'")->setMaxResults(2)->getQuery()->getResult();
    }
    public function getCount(){
        $a= $this->createQueryBuilder("r")->where("r.statut='Accepté'")->andWhere("r.boosted=false")->getQuery()->getResult();
        return sizeof($a);
    }
    public function findCampingsByOrganisateur($user)
    {
        $qb= $this->createQueryBuilder("c")
            ->where("c.organisateur=:user")
            ->setParameter("user",$user);
        $qb->orderBy("c.dateCreation","DESC");
       // var_dump("temtmem");
        return $qb->getQuery()->getResult();
    }
}