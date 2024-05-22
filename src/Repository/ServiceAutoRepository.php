<?php

namespace App\Repository;

use App\Entity\ServiceAuto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceAuto>
 *
 * @method ServiceAuto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAuto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAuto[]    findAll()
 * @method ServiceAuto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAuto::class);
    }

//    /**
//     * @return ServiceAuto[] Returns an array of ServiceAuto objects
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

//    public function findOneBySomeField($value): ?ServiceAuto
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
