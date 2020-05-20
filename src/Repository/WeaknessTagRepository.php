<?php

namespace App\Repository;

use App\Entity\WeaknessTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeaknessTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeaknessTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeaknessTag[]    findAll()
 * @method WeaknessTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaknessTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeaknessTag::class);
    }

    // /**
    //  * @return WeaknessTag[] Returns an array of WeaknessTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeaknessTag
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
