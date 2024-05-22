<?php

namespace App\Repository;

use App\Entity\ContratVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratVehicule>
 *
 * @method ContratVehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratVehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratVehicule[]    findAll()
 * @method ContratVehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratVehicule::class);
    }

//    /**
//     * @return ContratVehicule[] Returns an array of ContratVehicule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContratVehicule
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
