<?php

namespace App\Repository;

use App\Entity\SinisterLife;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SinisterLife>
 *
 * @method SinisterLife|null find($id, $lockMode = null, $lockVersion = null)
 * @method SinisterLife|null findOneBy(array $criteria, array $orderBy = null)
 * @method SinisterLife[]    findAll()
 * @method SinisterLife[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SinisterLifeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SinisterLife::class);
    }

//    /**
//     * @return SinisterLife[] Returns an array of SinisterLife objects
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

//    public function findOneBySomeField($value): ?SinisterLife
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
