<?php

namespace App\Repository;

use App\Entity\LifeRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LifeRequest>
 *
 * @method LifeRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method LifeRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method LifeRequest[]    findAll()
 * @method LifeRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LifeRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LifeRequest::class);
    }

//    /**
//     * @return LifeRequest[] Returns an array of LifeRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LifeRequest
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
