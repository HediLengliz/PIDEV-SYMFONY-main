<?php

namespace App\Repository;

use App\Entity\PropretyRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropretyRequest>
 *
 * @method PropretyRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropretyRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropretyRequest[]    findAll()
 * @method PropretyRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropretyRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropretyRequest::class);
    }

//    /**
//     * @return PropretyRequest[] Returns an array of PropretyRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PropretyRequest
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
