<?php

namespace App\Repository;

use App\Entity\MaisonReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaisonReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaisonReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaisonReservation[]    findAll()
 * @method MaisonReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaisonReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaisonReservation::class);
    }

    // /**
    //  * @return MaisonReservation[] Returns an array of MaisonReservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaisonReservation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
