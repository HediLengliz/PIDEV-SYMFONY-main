<?php

namespace App\Repository;

use App\Entity\ContratAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratAssurance>
 *
 * @method ContratAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratAssurance[]    findAll()
 * @method ContratAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratAssurance::class);
    }

//    /**
//     * @return ContratAssurance[] Returns an array of ContratAssurance objects
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

//    public function findOneBySomeField($value): ?ContratAssurance
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
