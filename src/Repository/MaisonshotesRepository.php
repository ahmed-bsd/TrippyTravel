<?php

namespace App\Repository;

use App\Entity\Maisonshotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maisonshotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maisonshotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maisonshotes[]    findAll()
 * @method Maisonshotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaisonshotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maisonshotes::class);
    }

    /**
      * @return Maisonshotes[]|NULL Returns an array of Maisonshotes objects
      **/

    public function findByExampleField($value)
    {
        $query= $this->createQueryBuilder('r');
         $query->andWhere(
               $query->expr()->like('r.libelle',  ':val')
          )
           ->setParameter('val', '%'.$value.'%');
        return $query->getQuery()->getResult();
    }
    public function findEntitiesByLibelle($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM App\Entity\Maisonshotes p
                WHERE p.libelle LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Maisonshotes
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
