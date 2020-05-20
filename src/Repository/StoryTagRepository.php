<?php

namespace App\Repository;

use App\Entity\StoryTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoryTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryTag[]    findAll()
 * @method StoryTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoryTag::class);
    }

    // /**
    //  * @return StoryTag[] Returns an array of StoryTag objects
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
    public function findOneBySomeField($value): ?StoryTag
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
