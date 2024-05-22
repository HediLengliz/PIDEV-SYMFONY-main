<?php

namespace App\Repository;

use App\Entity\SinisterVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SinisterVehicle>
 *
 * @method SinisterVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method SinisterVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method SinisterVehicle[]    findAll()
 * @method SinisterVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SinisterVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SinisterVehicle::class);
    }
    

//    /**
//     * @return SinisterVehicle[] Returns an array of SinisterVehicle objects
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

//    public function findOneBySomeField($value): ?SinisterVehicle
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
