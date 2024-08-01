<?php

namespace App\Repository;

use App\Entity\Measuring;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measuring>
 *
 * @method Measuring|null find($id, $lockMode = null, $lockVersion = null)
 * @method Measuring|null findOneBy(array $criteria, array $orderBy = null)
 * @method Measuring[]    findAll()
 * @method Measuring[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasuringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measuring::class);
    }

//    /**
//     * @return Measuring[] Returns an array of Measuring objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Measuring
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
