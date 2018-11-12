<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 09/02/2017
 * Time: 20:06
 */

namespace TahwissaBundle\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;

class RandonneeRepository  extends \Doctrine\ORM\EntityRepository
{
    public function getBoosted(){
        $qb= $this->createQueryBuilder("r");
        return $qb->where("r.boosted=true")->andWhere("r.statut='Accepté'")->setMaxResults(2)->getQuery()->getResult();
    }
    public function getCount(){
        $a= $this->createQueryBuilder("r")->where("r.statut='Accepté'")->andWhere("r.boosted=false")
            ->getQuery()->getResult();
        return sizeof($a);
    }

    public function getAllRandonness($currentPage = 1)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')

            ->orderBy('p.dateCreation', 'DESC')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function paginate($dql, $page=2,$limit=4){
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
    public function findAllSorted()
    {
        $qb= $this->createQueryBuilder("c");
        $qb->orderBy("c.dateCreation","DESC");
        return $qb->getQuery()->getResult();
    }
    public function findRandonneesByOrganisateur($user)
    {
        $qb= $this->createQueryBuilder("c")
            ->where("c.organisateur=:user")
            ->setParameter("user",$user);
        $qb->orderBy("c.dateCreation","DESC");

        return $qb->getQuery()->getResult();
    }
}