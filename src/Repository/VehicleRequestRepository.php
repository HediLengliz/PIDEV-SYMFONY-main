<?php

namespace App\Repository;

use App\Entity\VehicleRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleRequest>
 *
 * @method VehicleRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleRequest[]    findAll()
 * @method VehicleRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleRequest::class);
    }

//    /**
//     * @return VehicleRequest[] Returns an array of VehicleRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VehicleRequest
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
