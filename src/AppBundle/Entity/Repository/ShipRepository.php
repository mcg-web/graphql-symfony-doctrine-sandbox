<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ShipRepository extends EntityRepository
{
    public function countAllByFactionId($factionId)
    {
        return $this->shipByFactionIdQueryBuilder($factionId)
            ->select('COUNT(s)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function retrieveShipsIDsByFactionId($factionId, $offset = 0, $limit = 0)
    {
        $qb = $this->shipByFactionIdQueryBuilder($factionId);

        if ($limit > 0) {
            $qb->setMaxResults($limit);
        }

        return $ships = $qb->select('s.id')
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    private function shipByFactionIdQueryBuilder($factionId)
    {
        $qb = $this->createQueryBuilder('s')
            ->innerJoin('s.factions', 'f')
            ->where('f.id = :faction_id')
            ->setParameter('faction_id', $factionId)
        ;

        return $qb;
    }
}
