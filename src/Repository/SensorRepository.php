<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sensor>
 *
 * @method Sensor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sensor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sensor[]    findAll()
 * @method Sensor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensor::class);
    }



    /**
     * Find all sensors ordered by name.
     *
     * @return Wine[]
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.name', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Sensor[] Returns an array of Sensor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sensor
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
