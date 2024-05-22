<?php

namespace App\Repository;

use App\Entity\ServiceLife;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceLife>
 *
 * @method ServiceLife|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceLife|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceLife[]    findAll()
 * @method ServiceLife[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceLifeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceLife::class);
    }

//    /**
//     * @return ServiceLife[] Returns an array of ServiceLife objects
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

//    public function findOneBySomeField($value): ?ServiceLife
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
