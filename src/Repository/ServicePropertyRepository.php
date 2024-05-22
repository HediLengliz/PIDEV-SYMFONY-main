<?php

namespace App\Repository;

use App\Entity\ServiceProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceProperty>
 *
 * @method ServiceProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceProperty[]    findAll()
 * @method ServiceProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceProperty::class);
    }

//    /**
//     * @return ServiceProperty[] Returns an array of ServiceProperty objects
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

//    public function findOneBySomeField($value): ?ServiceProperty
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
