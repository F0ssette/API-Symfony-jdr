<?php

namespace App\Repository;

use App\Entity\Improvement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Improvement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Improvement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Improvement[]    findAll()
 * @method Improvement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImprovementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Improvement::class);
    }

    // /**
    //  * @return Improvement[] Returns an array of Improvement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Improvement
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
