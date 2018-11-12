<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 09/02/2017
 * Time: 21:55
 */

namespace TahwissaBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use TahwissaBundle\Entity\Evenement;

class EvenementRepository extends EntityRepository
{

    public function getBoosted(){
        return $this->createQueryBuilder("p")
            ->where("p.boosted=true")
            ->andWhere("p.statut='Accepté'")
            ->orderBy("p.dateCreation")
            ->getQuery()->getResult();
    }

    public function getAllEventsOrderByDateAjout($currentPage = 1)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->where("p.boosted=false")
            ->andWhere("p.statut='Accepté'")
            ->orderBy('p.dateCreation', 'DESC')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage,3);

        return $paginator;
    }

    public function getAllEventsOrderByDate($currentPage = 1)
    {
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->where("p.boosted=false")
            ->andWhere("p.statut='Accepté'")
            ->orderBy('p.dateHeureDepart', 'DESC')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage,3);

        return $paginator;
    }
    public function getEventsByDestinationOrderByDateAjout($currentPage = 1,$destination){
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->where("p.boosted=false")
            ->andWhere("p.statut='Accepté'")
            ->andWhere("p.destination LIKE :destination")
            ->setParameter("destination","%".$destination."%")
            ->orderBy('p.dateCreation', 'DESC')

            ->getQuery();

        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage,3);
        //var_dump($paginator);
        return $paginator;
    }
    public function getEventsByDestinationOrderByDate($currentPage = 1,$destination){
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->where("p.boosted=false")
            ->andWhere("p.statut='Accepté'")
            ->andWhere("p.destination LIKE :destination")
            ->setParameter("destination","%".$destination."%")
            ->orderBy('p.dateCreation', 'DESC')

            ->getQuery();
        //var_dump($query);
        // No need to manually get get the result ($query->getResult())

        $paginator = $this->paginate($query, $currentPage,3);

        return $paginator;
    }
    public function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);
        //var_dump($limit*($page-1));
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function getEnAttente(){
        $qb=$this->createQueryBuilder("e");
        $qb->where("e.statut=:statut")
            ->setParameter("statut",Evenement::$EN_ATTENTE)
            ->orderBy("e.dateCreation");
        return $qb->getQuery()->getResult();
    }

}