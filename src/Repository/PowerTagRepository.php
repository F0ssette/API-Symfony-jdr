<?php

namespace App\Repository;

use App\Entity\PowerTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PowerTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PowerTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PowerTag[]    findAll()
 * @method PowerTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PowerTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PowerTag::class);
    }

    // /**
    //  * @return PowerTag[] Returns an array of PowerTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PowerTag
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
