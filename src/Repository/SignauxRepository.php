<?php

namespace App\Repository;

use App\Entity\Signaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Signaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Signaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Signaux[]    findAll()
 * @method Signaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Signaux::class);
    }

    // /**
    //  * @return Signaux[] Returns an array of Signaux objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Signaux
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
