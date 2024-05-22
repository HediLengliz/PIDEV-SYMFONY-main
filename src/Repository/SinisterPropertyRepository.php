<?php

namespace App\Repository;

use App\Entity\SinisterProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SinisterProperty>
 *
 * @method SinisterProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method SinisterProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method SinisterProperty[]    findAll()
 * @method SinisterProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SinisterPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SinisterProperty::class);
    }
    public function findByUserId($userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.SinisterUser = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return SinisterProperty[] Returns an array of SinisterProperty objects
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

//    public function findOneBySomeField($value): ?SinisterProperty
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
