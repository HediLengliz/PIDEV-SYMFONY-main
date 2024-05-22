<?php

namespace App\Repository;

use App\Entity\InsuranceRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InsuranceRequest>
 *
 * @method InsuranceRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method InsuranceRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method InsuranceRequest[]    findAll()
 * @method InsuranceRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsuranceRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsuranceRequest::class);
    }

//    /**
//     * @return InsuranceRequest[] Returns an array of InsuranceRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InsuranceRequest
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
